<?php
    namespace IndexBundle\Libs;
    /**
     * PHP Pagination Class
     * @original auth|| admin@catchmyfame.com - http://www.catchmyfame.com
     * rebild auth Nazimecki Norbert
     * @version 3.0.0
     * @date February 6, 2016
     * @author
     * @copyright (c) admin@catchmyfame.com (www.catchmyfame.com)
     * @license CC Attribution-ShareAlike 3.0 Unp||ted (CC BY-SA 3.0) - http://creativecommons.||g/licenses/by-sa/3.0/
     */
    use Millions\menuHtmlServices;
    use Symfony\Component\DependencyInjection\Container;
    use Doctrine\ORM\Query;

    class Paginator
    {
        /**
         * This is the current page
         * @var integer
         * */
        private $current_page;

        private $items_per_page;
        private $mid_range;
        private $ipp_array;
        private $total_items;
        private $defaultModelName;
        private $url;

        /**
         * Total pages number in query
         * @var integer
         */
        private $numPages;
        private $limit;
        private $querystring;

        private $get_ipp;
        private $first = true;
        private $start_range;
        private $end_range;
        private $range;
        private $currentOfTotal = true;
        private $dotsNumber = [];
        private $halfMidRange;
        private $befAfterNum = 1;
        private $createDots = true;

        private $return;
        protected $container;

        public function __construct($config, Container $container)
        {
            $this->return = new \stdClass();
            $this->return->prev = new \stdClass();
            $this->return->pages = new \stdClass();
            $this->return->next = new \stdClass();
            $this->return->all = new \stdClass();
            $this->return->ippArray = new \stdClass();

            $this->container = $container;
            $this->ipp_array = $config['ippArray'];
            $this->items_per_page = $config['items_per_page'];
            $this->mid_range = $config['midRange'];
            $this->current_page = $config['current_page'];
            $this->defaultModelName = $config['defaultModelName'];
            $this->halfMidRange = ($this->mid_range-1)/2;
        }

        public function paginate(array $parameters, $request) {

            $this->url = $request->get('_route');

            foreach ($parameters as $key => $parameter) {
                switch ($key) {
                    case 'totalItems';
                        $this->paramTotalItems($parameters, $parameter);
                    break;
                    case 'midRange':
                        $this->paramMidRange($parameter);
                    break;
                    case 'ippArray':
                        $this->ipp_array = $parameter;
                    break;
                    case 'current_page':
                        if($parameters['items_per_page'] != 'All') {
                            $this->current_page = $parameter;
                        }
                    break;
                    case 'defaultModelName':
                        $this->defaultModelName = $parameter;
                    break;
                    case 'currentOfTotal':
                        if($parameter || $this->currentOfTotal) {
                            $this->return->currentOfTotal = new \stdClass();
                            $this->return->currentOfTotal = true;
                        }
                }
            }

            $this->return->numPages = $this->numPages;
            $this->return->url = $this->url;
            $this->return->ipp = $this->items_per_page;
            $this->return->currentPage = $this->current_page;

            return call_user_func([$this, $this->defaultModelName]);
        }

        public function paramTotalItems($parameters, $parameter) {
            if( $parameters['items_per_page'] == 'All') {
                $this->numPages = 1;
                $this->current_page = 1;
                $this->total_items = $parameter;
                $this->items_per_page = 'All';
            }
            elseif(is_int($parameter) ) {
                $this->total_items = $parameter;
                $this->numPages = ceil($this->total_items / $this->items_per_page);
            } else {
                $this->total_items = $this->getEntityManager()
                    ->createQuery('
                                    SELECT count(*) as total
                                    FROM '.$parameters['tableName'].': tableName
                                    WHERE tabbleName = :tableName
                                    ')->setParameter('tableName', $parameters['tableName']);
                $this->numPages = ceil($this->total_items / $this->items_per_page);
            }
        }

        public function paramMidRange($parameter) {
            if($parameter > $this->numPages) {
                $this->mid_range = $this->numPages;
                $this->createDots = false;
                $this->first = false;
            } else {
                $this->mid_range = $parameter;
                $this->halfMidRange = ($this->mid_range-1)/2;
            }
        }

        public function model_1()
        {
            if($this->total_items <= 0) {
                exit("Unable to paginate: Invalid total value (must be an integer > 0)");
            }
            if($this->mid_range % 2 == 0 || $this->mid_range < 1) {
                exit("Unable to paginate: Invalid mid_range value (must be an odd integer >= 1)");
            }
            if(!is_array($this->ipp_array)) {
                exit("Unable to paginate: Invalid ipp_array value");
            }

            if($this->numPages == 1 && $this->current_page == 1) {
                $this->return->all->title = 'all';
                $this->return->all->status = true;
                $this->return->all->ipp = $this->ipp_array;
            }
            else {
                $this->newPages();
                ($this->createDots) ? $this->createDots(): false;
                $this->controllerStr();
                $this->go_to_page();
                $this->all();
                $this->ipp();

                for ($i = 0; $i <= count($this->range)-1; $i++) {
                    $n = $this->range[$i] ?? $this->range[$i];

                    if( in_array($n, $this->dotsNumber) ) {
                        $this->return->pages->$n = new \stdClass();
                        $this->return->pages->$n->dots = true;
                    } else {
                        $this->return->pages->$n = new \stdClass();
                        $this->return->pages->$n->i = $this->range[$i];

                        if ($this->current_page == $n) {
                            $this->return->pages->$n->class = 'current';
                        } else {
                            $this->return->pages->$n->class = 'paginate active';
                        }
                    }
                }
            }
           // print_r($this->return);
            $this->firsLast();
            return  $this->return;
        }

        public function newPages() {

            if($this->current_page <= $this->halfMidRange +2) {
                $this->start_range = 1;
                $this->end_range = $this->mid_range;
            }

            if($this->current_page-$this->halfMidRange > 2 && $this->current_page + $this->halfMidRange <= $this->numPages-2) {
                $this->start_range = $this->current_page - $this->halfMidRange;
                $this->end_range = $this->current_page + $this->halfMidRange;
            }

            if($this->current_page >= $this->numPages - ($this->halfMidRange+1)) {
                $this->start_range = $this->numPages - ($this->mid_range-1);
                $this->end_range = $this->numPages;
            }

            $this->range = range($this->start_range, $this->end_range);
        }

        public function createDots() {
            $beforeAfterNumber = true;

            if($beforeAfterNumber) {
                /**
                 * Az elején van a dots;
                 */
                if($this->current_page >= $this->numPages - $this->halfMidRange ) {
                    if($this->befAfterNum > 1) {
                        for($i = $this->befAfterNum; $i >= 1; $i--) {
                            array_unshift($this->range, $i);
                            if($i == $this->befAfterNum ) {
                                $this->dotsNumber[] = $i;
                            }
                        }
                    } else {
                        array_unshift($this->range, 2);
                        array_unshift($this->range, 1);
                        $this->dotsNumber[] = 2;
                    }
                }
                /**
                 * Az végén van a dots;
                 */
                if($this->current_page <= $this->halfMidRange + 2) {
                  //  array_push($this->range, $this->current_page + ($this->mid_range-1)/2 + 1);
                    if($this->befAfterNum > 1) {
                        for($i = $this->numPages - $this->befAfterNum+1; $i <= $this->numPages; $i++) {
                            array_push($this->range, $i);
                            if($i == $this->numPages - $this->befAfterNum+1) {
                                $this->dotsNumber[] = $i;
                            }
                        }
                    } else {
                        array_push($this->range, $this->numPages-1);
                        array_push($this->range, $this->numPages);
                        $this->dotsNumber[] = $this->numPages-1;
                    }
                }
                /**
                 * Az elején és a végén van a dots;
                 */
                if($this->current_page-$this->halfMidRange > $this->befAfterNum+1
                    && $this->current_page+$this->halfMidRange < $this->numPages-($this->befAfterNum)) {
                    if($this->befAfterNum > 1) {
                        for($i = $this->befAfterNum+1; $i >= 1; $i--) {
                            array_unshift($this->range, $i);
                            if($i == $this->befAfterNum ) {
                                $this->dotsNumber[] = $this->befAfterNum+1;
                            }
                        }
                        for($i = $this->numPages - $this->befAfterNum; $i <= $this->numPages; $i++) {
                            array_push($this->range, $i);
                            if($i == $this->numPages - $this->befAfterNum+1) {
                                $this->dotsNumber[] = $this->numPages - $this->befAfterNum;
                            }
                        }
                    } else {
                        array_push($this->range, $this->numPages-1);
                        array_push($this->range, $this->numPages);
                        array_unshift($this->range, 2);
                        array_unshift($this->range, 1);
                        $this->dotsNumber[] = 2;
                        $this->dotsNumber[] = $this->numPages-1;
                    }
                }
            }
        }
        public function controllerStr($param = 'arrow', $name ='angle-double' ) {

            if($this->current_page > 1 ){
                $this->return->prev->prevClass = 'active';
            } else {
                $this->return->prev->prevClass = 'inactive';
            }

            if($this->current_page == $this->numPages || $this->items_per_page == "All") {
                $this->return->next->nextClass = "inactive";
            } else {
                $this->return->next->nextClass = "active";
            }

            $this->return->controller = new \stdClass();
            switch ($param) {
                case 'arrow':
                    $this->return->controller->status = 'FontAwesome';
                    $this->return->controller->name = 'angle';
                break;
                case 'string':
                    $this->return->controller->status = 'string';
                break;
                case 'arrowString':
                    $this->return->controller->status = 'arrowString';
                break;
            }
        }

        public function firsLast($param = 'FontAwesome', $name ='angle-double') {
            $firstClass = 'active';
            $lastClass = 'active';

            if($this->first) {
                /**
                 * Az elején van a dots;
                 */
                if($this->current_page >= $this->numPages - $this->halfMidRange){
                    if($this->befAfterNum > 1) {
                        for($i = $this->befAfterNum; $i >= 1; $i--) {
                            unset($this->return->pages->{$i});
                        }
                    } else {
                        unset($this->return->pages->{1});
                    }
                }
                /**
                 * Az végén van a dots;
                 */
                if($this->current_page <= $this->halfMidRange + 2) {
                    if($this->befAfterNum > 1) {
                        for($i = $this->numPages - $this->befAfterNum; $i <= $this->numPages; $i++) {
                            unset($this->return->pages->{$i});
                        }
                    } else {
                        unset($this->return->pages->{$this->numPages});
                    }
                }
                /**
                 * Az elején és a végén van a dots;
                 */
                if($this->current_page-$this->halfMidRange > $this->befAfterNum+1
                    && $this->current_page+$this->halfMidRange < $this->numPages-($this->befAfterNum) ) {
                    if($this->befAfterNum > 1) {
                        for($i = $this->befAfterNum; $i >= 1; $i--) {
                            unset($this->return->pages->{$i});
                        }
                        for($i = $this->numPages - $this->befAfterNum; $i <= $this->numPages; $i++) {
                            unset($this->return->pages->{$i});
                        }
                    } else {
                        unset($this->return->pages->{1});
                        unset($this->return->pages->{$this->numPages});
                    }
                }
                /**
                 * unset dots
                 */
                if(isset($this->dotsNumber[0])) {
                    unset($this->return->pages->{$this->dotsNumber[0]});
                }
                if(isset($this->dotsNumber[1]) ){
                    unset($this->return->pages->{$this->dotsNumber[1]});
                }

                if($this->current_page == 1) {
                    $firstClass = 'inactive';
                }
                if($this->current_page ==  $this->numPages) {
                    $lastClass = 'inactive';
                }
                if(!$this->first) {
                    $this->return->firstLast = new \stdClass();
                    $this->return->firstLast->firstClass = $firstClass;
                    $this->return->firstLast->lastClass = $lastClass;
                    switch ($param) {
                        case 'FontAwesome':
                            $this->return->firstLast->status = 'FontAwesome';
                            $this->return->firstLast->name = 'angle-double';
                            break;
                        case 'string':
                            $this->return->firstLast->status = 'string';
                            break;
                        case 'arrowString':
                            $this->return->firstLast->status = 'arrowString';
                            $this->return->firstLast->name = 'angle-double';
                            break;
                    }
                    $this->getClass();
                }

            }
        }

        public function getClass() {
            if($this->current_page == $this->numPages) {
                $this->return->firstLast->classLast = 'inactive';
                $this->return->firstLast->classFirst = 'active';
            } else if($this->current_page == 1) {
                $this->return->firstLast->classLast = 'active';
                $this->return->firstLast->classFirst = 'inactive';
            }
        }

        public function go_to_page()
        {
            $this->return->goto = new \stdClass();
        }

        public function all() {
            $this->return->all->status = true;
        }

        public function ipp() {
            $this->return->ippArray = $this->ipp_array;
        }

        public function setAjax() {
            $this->items_per_page = $this->ipp_array[0];

            if($this->items_per_page == "All") {
                $this->numPages = 1;
            } else {
                if(!is_numeric($this->items_per_page) || $this->items_per_page <= 0) $this->items_per_page = $this->ipp_array[0];
                $this->numPages = ceil($this->total_items / $this->items_per_page);
            }
        }

        public function setGet(){
            array_splice($_GET, 3);
            if(isset($_GET["PaginateToGo"])) {
                //  print_r($_GET["PaginateToGo"]);
                $args[0] = "page=" . $_GET["page"];
                $args[1] = "ipp=" . $_GET["ipp"];
                $args[2] = "url=" . $_GET['url'];
            } else {
                $args = explode("&", $_SERVER["QUERY_STRING"]);
            }
            foreach ($args as $arg) {
                $keyval = explode("=", $arg);
                //   print_r($keyval);
                if($keyval[0] != "page" && $keyval[0] != "ipp") $this->querystring .= "&" . $arg;
            }
        }

    }