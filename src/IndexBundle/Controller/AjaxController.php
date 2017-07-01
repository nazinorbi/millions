<?php

namespace IndexBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use IndexBundle\Libs\AbsBootstrap;


class AjaxController extends AbsBootstrap {

    private $translated = [];
    private $logoutName = 'login';
    private $data;
    private $response;
    protected $request;

    /**
     * @Route("/ajax", name="ajax")
     * @Method({"GET", "POST"})
     */
    public function ajaxAction(Request $request)  {
        
        $this->request = $request;

        $this->data = (object)($request->request->get('data'));
        $instance = $request->request->get('instance');
        $this->data->url = $instance ? $request->get('_route') : false;
        $right = (object)($request->request->get('right'));

        $this->setTranslate();

        switch ($instance) {
            case 'login':
                $this->login($this->data, $login = true);
                break;
            case 'lang':
                $this->translated($this->data);
                break;
            case 'logout':
                $this->logoutName = 'login';
                if(isset($_SESSION['user'])) {
                    unset($_SESSION['user']);
                    //session_destroy();
                }
                $this->login($this->data, $login = false);
                break;
            case 'checkTransNum':
                $this->controllerCall('Index');
                break;
            default:
                  $this->controllerCall($instance);
            break;
        }

        return new Response($this->response);
    }

    public function translated($data) {
        if(isset($data->lang)) {
            $this->get('translator')->setLocale($data->lang);
            $_SESSION['local'] = $data->lang;
        } elseif (isset($_SESSION['local'])) {
            $this->get('translator')->setLocale($_SESSION['local']);
        }

        if(isset($data->trans)) {
            foreach ($data->trans as $index => $value) {
                $this->translated[$index] = $this->get('translator')->trans($value);
            }
            $this->response = json_encode($this->translated);
        }
    }

    public function login($data, $login) {
        $userRank = null;

        if($login) {
            $this->container->get('login')->loginRouting($data);
                $this->logoutName = 'logout';
        }

        if(isset($_SESSION['user'])) {
            $userRank = $_SESSION['user']->userRank;
        }

        $this->response = json_encode([
            'login' =>  $this->renderView($this->logoutName.'.twig', [
                        'nicname' => $this->get('translator')->trans('NICNAME'),
                        'password' => $this->get('translator')->trans('PASSWORD'),
                        'lang_login' => $this->get('translator')->trans('LOGIN'),
                        'logout' => $this->get('translator')->trans('LOGOUT'),
                        'lang_reg' => $this->get('translator')->trans('REGISTRATION'),
                        'userRank' => $userRank
                    ]),
            'menu' => $this->getMenu()
        ]);
    }

    public function controllerCall($classNameValue) {
        $this->response = $this->forward('IndexBundle:'.ucfirst($classNameValue).':index', [
            'data' => $this->data,
            'ajax' => true
        ])->getContent();
    }
}
