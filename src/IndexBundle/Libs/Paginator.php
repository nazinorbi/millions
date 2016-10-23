<?php
    namespace Millions;
    /**
     * PHP Pagination Class
     * @author admin@catchmyfame.com - http://www.catchmyfame.com
     * @version 3.0.0
     * @date February 6, 2014
     * @copyright (c) admin@catchmyfame.com (www.catchmyfame.com)
     * @license CC Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0) - http://creativecommons.org/licenses/by-sa/3.0/
     */

    class Paginate
    {
        public $current_page;
        public $items_per_page;
        public $limit_end;
        public $limit_start;
        public $num_pages;
        public $total_items;
        public $ipp_array;
        protected $limit;
        protected $mid_range;
        protected $querystring;
        public $return;
        protected $get_ipp;
        public $container;
        private $twig;
        private $lang;
        private $url;
        private $instance;

        public function setContainer($container)
        {
            $this->container = $container;
        }

        public function  setValue($value)
        {
            $this->mid_range = (int)$value->midRange;
            $this->total_items = (int)$value->maxNumRows;
           // $this->ipp_array = array( 3, 6, 9, 12, 25, 50, 100, 250, 'All');
            $this->ipp_array = $value->ippArray;
            $this->instance = $value->instance;
            $this->current_page = $value->current_page;
            $this->lang = $value->lang;

            if(isset($_GET["url"])) {
                $this->url = $_GET["url"];
            } elseif(isset($_POST['data']['url'])) {
                $this->url = $_POST['data']['url'];
            }

            $this->getLang();
            $this->paginate();
        }

        public function RunModel()
        {
            $this->paginate();
        }

        public function paginate()
        {
            $this->twig = $this->container->get('getTwigObj')->getTwigObj();
            if($this->total_items <= 0) {
                exit("Unable to paginate: Invalid total value (must be an integer > 0)");
            }
            if($this->mid_range % 2 == 0 Or $this->mid_range < 1) {
                exit("Unable to paginate: Invalid mid_range value (must be an odd integer >= 1)");
            }
            if(!is_array($this->ipp_array)) {
                exit("Unable to paginate: Invalid ipp_array value");
            }

            if(isset($_POST['ajax']) ) {
                //$this->items_per_page = (isset($_POST["data"]['ipp'])) ? $_POST["data"]['ipp'] : $this->ipp_array[0];
                $this->items_per_page = $this->ipp_array[0];
                $this->default_ipp = 6;

                if($this->items_per_page == "All") {
                    $this->num_pages = 1;
                } else {
                    if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->ipp_array[0];
                    $this->num_pages = ceil($this->total_items / $this->items_per_page);
                }
            } else {
                $this->items_per_page = (isset($_GET["ipp"])) ? $_GET["ipp"] : $this->ipp_array[0];
                $this->default_ipp = $this->ipp_array[0];

                if($this->items_per_page == "All") {
                    $this->num_pages = 1;
                } else {
                    if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->ipp_array[0];
                    $this->num_pages = ceil($this->total_items / $this->items_per_page);
                }

                $this->current_page = (isset($_GET["page"])) ? (int)$_GET["page"] : 1; // must be numeric > 0
            }

            if($_GET) {
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
                    if($keyval[0] != "page" And $keyval[0] != "ipp") $this->querystring .= "&" . $arg;
                }
            }

           if($this->num_pages > 10) {
                if(($this->current_page > 1 And $this->total_items >= 10)) {
                    $this->return = $this->twig->render('Paginate.twig', array("tag" => array(

                    )));
                } else {
                    $this->return = $this->twig->render("Paginate.twig", array("tag" => array(
                            "1" => array(
                                "params" => array(
                                    "tagName"  =>"span",
                                    "odd_even" => "odd",
                                    "transparency" => 'true',
                                    "instance" => $this->instance,
                                    "class"    => "paginBut inactive",
                                    "html"     => $this->lang['Previous']
                                ))))
                    );
                }
                $this->start_range = $this->current_page - floor($this->mid_range / 2);
                $this->end_range = $this->current_page + floor($this->mid_range / 2);
                if($this->start_range <= 0) {
                    $this->end_range += abs($this->start_range) + 1;
                    $this->start_range = 1;
                }
                if($this->end_range > $this->num_pages) {
                    $this->start_range -= $this->end_range - $this->num_pages;
                    $this->end_range = $this->num_pages;
                }
                $this->range = range($this->start_range, $this->end_range);
                for ($i = 1; $i <= $this->num_pages; $i++) {
                    if($this->range[0] > 2 And $i == $this->range[0]) {
                        $this->return .= $this->twig->render('Paginate.twig', array("tag" => array(
                            "1" => array(
                                "params" => array(
                                    "odd_even" => "odd",
                                    "tagName"  => "span",
                                    "class"    => "point",
                                    "html"     => "..."
                                ))
                        )));
                    }
                    if($i == 1 Or $i == $this->num_pages Or in_array($i, $this->range)) {
                        if($i == $this->current_page And $this->items_per_page != "All") {
                            $this->return .= $this->twig->render('Paginate.twig', array("tag" => array(
                                "1" => array(
                                    "params" => array(
                                        "odd_even" => "odd",
                                        "tagName"  =>"span",
                                        "transparency" => 'true',
                                        "instance" => $this->instance,
                                        "class"    => "current paginBut",
                                        "title"    => "Go to page" . $i . "of" . $this->num_pages,
                                        "html"     => $i,
                                    )),
                            )));
                        } else {
                            $this->return .= $this->twig->render('Paginate.twig', array("tag" => array(
                                "1" => array(
                                    "params" => array(
                                        "odd_even" => "odd",
                                        "tagName"  =>"span",
                                        "transparency" => 'true',
                                        "instance" => $this->instance,
                                        "class"    => "paginBut pointer",
                                        "title"    => "Go to page " . $i . " of " . $this->num_pages,
                                        "href"     => array(
                                            "url"  => $this->url,
                                            "ipp"  => (int)$this->items_per_page,
                                            "page" => $i
                                        ),
                                        "html"     => $i,
                                    )),
                            )));
                        }
                    }
                    if($this->range[ $this->mid_range - 1 ] < $this->num_pages - 1 And $i == $this->range[ $this->mid_range - 1 ]) {
                        $this->return .= $this->twig->render('Paginate.twig', array("tag" => array(
                            "1" => array(
                                "params" => array(
                                    "odd_even" => "odd",
                                    "tagName"  => "span",
                                    "class"    => "point paginBut",
                                    "html"     => "...",
                                )),
                        )));
                    }
                } //end for
                if($this->current_page < $this->num_pages And $this->total_items >= 10 And $this->items_per_page != "All" And $this->current_page > 0) {
                    $this->return .= $this->twig->render('Paginate.twig', array("tag" => array(
                        "1" => array(
                            "params" => array(
                                "odd_even" => "odd",
                                "tagName"  =>"span",
                                "transparency" => 'true',
                                "instance" => $this->instance,
                                "class"    => "paginBut active pointer",
                                "title"    => "Go to page " . ($this->current_page + 1) . " of " . $this->num_pages,
                                "href"     => array(
                                    "url"  => $this->url,
                                    "ipp"  => (int)$this->items_per_page,
                                    "page" => $this->current_page + 1,
                                ),
                                "html"     => "Next",
                            )),
                    )));
                } else {
                    $this->return .= $this->twig->render('Paginate.twig', array("tag" => array(
                        "1" => array(
                            "params" => array(
                                "odd_even" => "odd",
                                "tagName"  =>"span",
                                "transparency" => 'true',
                                "instance" => $this->instance,
                                "class"    => "paginBut inactive",
                                "title"    => "The last page is",
                                "html"     => "Next",
                            )),
                    )));
                }
                if($this->items_per_page == "All") {
                    $this->return .= $this->twig->render('Paginate.twig', array("tag" => array(
                        "1" => array(
                            "params" => array(
                                "odd_even" => "odd",
                                "tagName"  =>"span",
                                "transparency" => 'true',
                                "instance" => $this->instance,
                                "class"    => "paginBut current",
                                "style"    => "margin-left:10px",
                                "html"     => "All",
                            )),
                    )));
                } else {
                    $this->return .= $this->twig->render('Paginate.twig', array("tag" => array(
                        "1" => array(
                            "params" => array(
                                "odd_even" => "odd",
                                "tagName"  =>"span",
                                "transparency" => 'true',
                                "instance" => $this->instance,
                                "class"    => "paginBut inactive",
                                "style"    => "margin-left:10px",
                                "html"     => "All",
                                "href"     => array(
                                    "url"  => $this->url,
                                    "ipp"  => "All",
                                    "page" => "1"
                                )
                            )),
                    )));
                }
                // if($this->num_pages < 10)
            } else {
                for ($i = 1; $i <= $this->num_pages; $i++) {
                    if($i == $this->current_page) {
                        $this->return .= $this->twig->render('Paginate.twig', array("tag" => array(
                            "1" => array(
                                "params" => array(
                                    "odd_even" => "odd",
                                    "tagName"  =>"span",
                                    "transparency" => 'true',
                                    "instance" => $this->instance,
                                    "class"    => "paginBut current",
                                    "html"     => $i,
                                )),
                        )));
                    } else {
                        $this->return .= $this->twig->render('Paginate.twig', array("tag" => array(
                            "1" => array(
                                "params" => array(
                                    "odd_even" => "odd",
                                    "tagName"  =>"span",
                                    "transparency" => 'true',
                                    "instance" => $this->instance,
                                    "class"    => "paginBut pointer",
                                    "html"     => $i,
                                    "href"     => array(
                                        "url"  => $this->url,
                                        "ipp"  => $this->items_per_page,
                                        "page" => $i
                                    ))),
                        )));
                    }
                }

                $this->return .= $this->twig->render('Paginate.twig', array("tag" => array(
                    "1" => array(
                        "params" => array(
                            "odd_even" => "odd",
                            "tagName"  =>"span",
                            "transparency" => 'true',
                            "instance" => $this->instance,
                            "class"    => "paginBut active pointer",
                            "html"     => "All",
                            "href"     => array(
                                "url"  => $this->url,
                                "ipp"  => "All",
                                "page" => "1"
                            )
                        )),
                )));
            }
            $this->return = str_replace("&", "&amp;", $this->return);
            $this->limit_start = ($this->current_page <= 0) ? 0 : ($this->current_page - 1) * $this->items_per_page;
            if($this->current_page <= 0) $this->items_per_page = 0;
            if($this->current_page == 0) {
                $endPagePlus = 2;
            } else {
                $endPagePlus = 0;
            }
            $this->limit_end = ($this->items_per_page == "All") ? (int)$this->total_items :$endPagePlus + (int)$this->items_per_page;
        }

        public function display_items_per_page()
        {
            natsort($this->ipp_array);

            return $this->twig->render('PaginateItems.twig', array(
                "spanClass"   => "items",
                "selectclass" => "itemsSelect",
                "array"       => $this->ipp_array,
                "selected"    => $this->items_per_page,
                "href"        => array(
                    "url"  => "http://localhost/WebMillions/index.php&url=User",
                )
            ));
        }

        public function display_jump_menu()
        {
            $option = NULL;
            for ($i = 1; $i <= $this->num_pages; $i++) {
                $option .= ($i == $this->current_page) ? "<option value=\"$i\" selected>$i</option>\n" : "<option value=\"$i\">$i</option>\n";
            }

            return "<span class=\"paginate\">Page:</span><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?page='+this[this.selectedIndex].value+'&amp;ipp=$this->items_per_page$this->querystring';return false\">$option</select>\n";
        }

        public function  go_to_page()
        {
            return $this->twig->render('Paginate.twig', array("tag" => array(
                "2" => array(
                    "params" => array(
                        "odd_even" => "even",
                        "tagName"  => "input",
                        "class"       => "inputPage",
                        "type"     => "number",
                        "min"      => "1",
                        "max"      => (int)$this->num_pages,
                    )),
                "3" => array(
                    "params" => array(
                        "odd_even" => "even",
                        "tagName"  => "input",
                        "id"       => "url",
                        "type"     => "hidden",
                        "value"    => $this->url
                    )),
                "4" => array(
                    "params" => array(
                        "odd_even" => "even",
                        "tagName"  => "input",
                        "class"       => "ipp",
                        "type"     => "hidden",
                        "value"    => $this->items_per_page
                    )),
                "1" => array(
                    "params" => array(
                        "odd_even" => "odd",
                        "tagName"  =>"span",
                        "transparency" => 'true',
                        "instance" => $this->instance,
                        "class"    => "paginateToGo paginate",
                        "href"     => array(
                            "url"  => $this->url,
                            "ipp"  => (int)$this->items_per_page,
                            "page" => $this->current_page
                        ),
                        "html"     => $this->lang['go'],
                    )),
            )));
        }

        public function getLang()
        {
            $this->lang = $this->container->get('language')->getLang("paginator");
        }

        public function getJsScript()
        {
            return $this->twig->render("PaginatorJavaScript.twig", array(
                "url" => "http://localhost/WebMillions/index.php&url=User",
            ));
        }

        public function getCss()
        {
            return array("css/Paginate.css");
        }
    }