<?php

namespace IndexBundle\Model;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

class Menu {
    private $menu;
    private $name;
    private $url;
    private $pClass = "";
    private $sub = false;
    private $lang;
    private $em;
    private $translated;
    private $userRank = false;
    protected $container;

    public function __construct($menu, Container $container, EntityManager $em)
    {
        $this->container = $container;
        $this->em = $em;
        $this->menu = $menu;
        $this->translated = $this->container->get('translator');
    }

    public function getMenuArray($lang)
    {
        $this->lang = $lang;
        return $this->menuFactory($this->menu);
    }

    public function getMenu()
    {
        $this->setUserRank();
        return $this->menuFactory($this->menu);
    }

    public function menuFactory($menuArray, $is_sub = false)
    {
        $attrLi = null;
        //print_r($menuArray);
        (!$is_sub) ? $attrUL = 'id="menu" class="menu"' : $attrUL = '';

        $menu = "<ul " . $attrUL . ">\n";
        if(is_array($menuArray) || is_object($menuArray)) {
            foreach ($menuArray as $id => $elem) {
                $rank = ($menuArray[$id]['rank']);

                if ($this->chechkRank($rank)) {
                    $sub = "";
                    foreach ($elem as $key => $val) {
                        switch ($val) {
                            case ($key == 'sub' && is_array($val)):
                                $this->sub = true;
                                $sub = $this->menuFactory($val, true);
                            break;
                            case ($key == 'display') :
                                if(isset($elem['url'])) {
                                    $this->url = $elem['url'];
                                }
                                $this->name = $val;

                                if($this->sub && !empty($elem['sub'])) {
                                    $attrLi = "class='fa fa-caret-down submenu'  aria-hidden='true'";
                                    $this->pClass = 'sf-with-ul ajaxBut';
                                } else  {
                                    $attrLi = "class='' ";
                                    $this->pClass = 'ajaxBut';
                                }
                            break;
                        }
                    }
                    $menu .= "<li " . $attrLi . "><p class=".$this->pClass." instance=".lcfirst($this->name)." >".$this->name."</p>" . $sub . "</li>\n";

                    if ($is_sub) {
                        unset ($attrLi);
                        unset ($this->name);
                    }
                }
            }
        }
        return $menu . "</ul>\n";
    }

    public function setUserRank() {
        if (isset($_SESSION['user']) ) {
            $this->userRank = $_SESSION['user']->userRank;
        } else {
            $this->userRank = 'public';
        }
    }

    public function chechkRank($rank)
    {
        if($rank[0] == 'public') {
            return true;
        } else if(in_array($this->userRank, $rank)) {
            return true;
        } else {
            return false;
        }
    }
}
   
