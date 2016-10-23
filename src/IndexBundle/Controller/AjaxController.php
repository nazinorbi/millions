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
    private $response;
    protected $request;

    /**
     * @Route("/ajax", name="ajax")
     * @Method({"GET", "POST"})
     */
    public function ajaxAction(Request $request)  {

        $this->request = $request;

        $data = (object)($request->request->get('data'));
        $instance = $request->request->get('instance');
        $right = (object)($request->request->get('right'));

        switch ($instance) {
            case 'login':
                $this->login($data, $login = true);
                break;
            case 'lang':
                $this->translated($data);
                break;
            case 'logout':
                $this->logoutName = 'login';
                unset($_SESSION['user']);
                session_destroy();
                $this->login($data, $login = false);
                break;
            case ('strati') :
                return $this->strati();
                break;
        }
        return new Response($this->response,200);
    }

    public function translated($data) {
        $this->get('translator')->setLocale($data->lang);

        if(isset($data->trans)) {
            foreach ($data->trans as $index => $value) {
                $this->translated[$index] = $this->get('translator')->trans($value);
            }
        }
        $this->response = json_encode($this->translated);
    }

    public function login($data, $login) {

        if($login) {
            $this->container->get('login')->loginRouting($data);
                $this->logoutName = 'logout';
        }

        $this->response = json_encode([
            'login' =>  $this->renderView($this->logoutName.'.twig', [
                        'nicname' => $this->get('translator')->trans('NICNAME'),
                        'password' => $this->get('translator')->trans('PASSWORD'),
                        'lang_login' => $this->get('translator')->trans('LOGIN'),
                        'logout' => $this->get('translator')->trans('LOGOUT'),
                        'lang_reg' => $this->get('translator')->trans('REGISTRATION'),
                    ]),
            'menu' => $this->getMenu()
        ]);
    }

    public function strati() {
        return ($this->get('manual_forward')
                     ->handleForward($this->request, $bundleName = 'IndexBundle', $className = 'Strati', $functionName = 'index'));
    }
}
