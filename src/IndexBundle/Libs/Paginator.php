<?php
    namespace IndexBundle\Libs;
    /**
     * PHP Pagination Class
     * @auth|| admin@catchmyfame.com - http://www.catchmyfame.com
     * @version 3.0.0
     * @date February 6, 2014
     * @copyright (c) admin@catchmyfame.com (www.catchmyfame.com)
     * @license CC Attribution-ShareAlike 3.0 Unp||ted (CC BY-SA 3.0) - http://creativecommons.||g/licenses/by-sa/3.0/
     */
    use Symfony\Component\DependencyInjection\Container;
    use Doctrine\ORM\Query;

    class Paginator
    {

        private $current_page;
        private $items_per_page;
        private $mid_range;
        private $ipp_array;
        private $total_items;
        private $defaultModelName;
        private $url;

        private $limit_end;
        private $limit_start;
        private $numPages;
        private $limit;
        private $querystring;

        private $get_ipp;
        private $start_range;
        private $end_range;
        private $range;

        private $return;
        protected $container;

        public function __construct($config, Container $container)
        {
            $this->createReturnObj();

            $this->container = $container;
            $this->ipp_array = $config['ippArray'];
            $this->items_per_page = $config['items_per_page'];
            $this->mid_range = $config['midRange'];
            $this->current_page = $config['current_page'];
            $this->defaultModelName = $config['defaultModelName'];
        }

        public function paginate(array $parameters, $request) {

            $this->url = $request->get('_route');

            foreach ($parameters as $key => $parameter) {
                switch ($key) {
                    case 'totalItems';
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
                    break;
                    case 'midRange':
                        $this->mid_range = $parameter;
                    break;
                    case 'ippArray':
                        $this->ipp_array = $parameter;
                    break;
                    case 'current_page':
                        if($parameters['items_per_page'] !== 'All') {
                            $this->current_page = $parameter;
                        }
                    break;
                    case 'defaultModelName':
                        $this->defaultModelName = $parameter;
                    break;
                }
            }

            return call_user_func([$this, $this->defaultModelName]);
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

            $this->return->numPages = $this->numPages;
            if($this->numPages == 1 && $this->current_page == 1) {
                $this->return->all->title = 'all';
                $this->return->all->status = true;
                $this->return->all->ipp = $this->ipp_array;
            }
            else if($this->numPages > 10) {
                $this->start_range = $this->current_page - floor($this->mid_range / 2);//1
                $this->end_range = $this->current_page + floor($this->mid_range / 2);//7
                if($this->start_range <= 0) {
                    $this->end_range += abs($this->start_range) + 1;
                    $this->start_range = 1;
                }
                if($this->end_range > $this->numPages) {
                    $this->start_range -= $this->end_range - $this->numPages;
                    $this->end_range = $this->numPages;
                }
                $this->range = range($this->start_range, $this->end_range);

                if($this->current_page-($this->mid_range-1)/2 <= 2) {
                    $this->return->prev->status = false;
                } else {
                    $this->return->prev->status = true;
                    $this->return->prev->page = $this->current_page - 1;
                    $this->return->prev->url = $this->url;
                    $this->return->prev->ipp = $this->items_per_page;
                }
                for ($i = 1; $i <= $this->numPages; $i++) {
                    if($this->range[0] > 2 && $i == $this->range[0]-1) {
                        $this->return->pages->$i = new \stdClass();
                        $this->return->pages->$i->dots = true;
                    }
                    if($i == 1 || $i == $this->numPages || in_array($i, $this->range)) {
                        $this->return->pages->$i = new \stdClass();
                        $this->return->pages->$i->i = $i;
                        $this->return->pages->$i->dots = false;
                        $this->return->pages->$i->url = $this->url;
                        $this->return->pages->$i->ipp = $this->items_per_page;
                        $this->return->pages->$i->title = $this->numPages;

                        if($i == $this->current_page && $this->items_per_page != "All") {
                            $this->return->pages->$i->class = 'current';
                        } else {
                            $this->return->pages->$i->class = 'paginate active';
                        }
                    }
                    if($i == $this->numPages-1 && $i > end($this->range) ) {
                        $this->return->pages->$i = new \stdClass();
                        $this->return->pages->$i->dots = true;
                    }
                } //end for
                if($this->current_page + ($this->mid_range-1)/2 >= $this->numPages-1) {
                    $this->return->next->status = false;
                } else {$this->return->next->status = true;
                    $this->return->next->url = $this->url;
                    $this->return->next->page = $this->current_page + 1;
                    $this->return->next->ipp = (int)$this->items_per_page;
                }
                if($this->items_per_page == "All") {
                    $this->return->all->status = true;
                } else {
                    $this->return->all->status = false;
                    $this->return->all->ipp = $this->ipp_array;
                }
                // if($this->numPages < 10)
            } else {
                for ($i = 1; $i <= $this->numPages; $i++) {
                    $this->return->pages->$i = new \stdClass();
                    $this->return->pages->$i->url = $this->url;
                    $this->return->pages->$i->ipp = (int)$this->items_per_page;
                    $this->return->pages->$i->title = $this->numPages;
                    $this->return->pages->$i->i = $i;

                    if($i == $this->current_page && $this->items_per_page != "All") {
                        $this->return->pages->$i->class = 'current';
                    } else {$this->return->pages->$i->class = 'paginate active';
                    }
                }
                $this->return->all->url =  $this->url;
                $this->return->all->ipp = 'All';
            }
            //$this->return = str_replace("&", "&amp;", $this->return);
            $this->limit_start = ($this->current_page <= 0) ? 0 : ($this->current_page - 1) * $this->items_per_page;
            if($this->current_page <= 0) $this->items_per_page = 0;
            if($this->current_page == 0) {
                $endPagePlus = 2;
            } else {
                $endPagePlus = 0;
            }
            $this->limit_end = ($this->items_per_page == "All") ? (int)$this->total_items :$endPagePlus + (int)$this->items_per_page;

            //print_r($this->return);
            return  $this->return;
        }

        public function createReturnObj() {
            $this->return = new \stdClass();
            $this->return->prev = new \stdClass();
            $this->return->pages = new \stdClass();
            $this->return->next = new \stdClass();
            $this->return->all = new \stdClass();
        }

        public function display_items_per_page()
        {
            natsort($this->ipp_array);

           /** return $this->twig->render('PaginateItems.twig', array(
                "spanClass"   => "items",
                "selectclass" => "itemsSelect",
                "array"       => $this->ipp_array,
                "selected"    => $this->items_per_page,
                "href"        => array(
                    "url"  => "http://localhost/WebMillions/index.php&url=User",
                )
            ));*/
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

        public function display_jump_menu()
        {
            $option = NULL;
            return $this->renderView('display_jump_menu.twig', [
                'numPages' => $this->numPages,
                'url' => $this->url,
                'items_per_page' => $this->items_per_page
            ]);
        }

        public function  go_to_page()
        {
            return $this->renderView('go_to_page.twig', [
                'max' => (int)$this->numPages,
                'url' => $this->url,
                'items_per_page' => $this->items_per_page
            ]);
        }


        
    }