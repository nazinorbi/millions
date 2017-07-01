<?php
/**
 * Created by PhpStorm.
 * User: nazi
 * Date: 2016.08.08.
 * Time: 5:26
 */

namespace IndexBundle\Libs;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

abstract class AbsBootstrap extends Controller {

    private $logoutName = 'login';
    private $translated;

    public function bootstrapRun($center) {
        $userRank = null;
        $this->setTranslate();

        if(isset($_POST['login']) || isset($_SESSION['user'])) {
            if($this->container->get('login')->loginRouting($_SESSION['user'])) {
               // $this->get('user')->setUser($_SESSION['user']);
                $this->logoutName = 'logout';
            }
        }

        if(isset($_SESSION['user'])) {
            $userRank = $_SESSION['user']->userRank;
        }
        return new Response($this->renderView('index.html.twig'
            ,[  'headNames' => $this->getHeader(),
                'alt' => 'majd',
                'title' => 'majd',
                'menu' => $this->getMenu(),
                'login' => $this->renderView($this->logoutName.'.twig', [
                    'nicname' => $this->get('translator')->trans('NICNAME'),
                    'password' => $this->get('translator')->trans('PASSWORD'),
                    'lang_login' => $this->get('translator')->trans('LOGIN'),
                    'logout' => $this->get('translator')->trans('LOGOUT'),
                    'lang_reg' => $this->get('translator')->trans('REGISTRATION'),
                    'userRank' => $userRank
                ]),
                'lang' => $this->renderView('lang.twig', []),
                'center' => $center
        ]), 200);
    }

    public function setTranslate() {
        $this->translated = $this->container->get('translator');
        if(isset($_SESSION['local'])) {
            $this->translated->setLocale($_SESSION['local']);
        } else {
            $this->translated->setLocale('hu');
        }
    }


    public function getHeader() {
        return $this->container->get('header')
            ->getImageNames('16:9');
    }

    public function getMenu() {
        return  $this->container->get('menu')->getMenu();
    }

}