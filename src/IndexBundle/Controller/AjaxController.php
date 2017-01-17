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
        $right = (object)($request->request->get('right'));

        switch ($instance) {
            case 'login':
                $this->login($this->data, $login = true);
                break;
            case 'lang':
                $this->translated($this->data);
                break;
            case 'logout':
                $this->logoutName = 'login';
                unset($_SESSION['user']);
                session_destroy();
                $this->login($this->data, $login = false);
                break;
            default:
                  $this->controllerCall($instance);
               /* if($request instanceof Response) {
                    echo 'fhfxgsd';
                    return $request;
                }*/

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

    public function controllerCall($classNameValue) {
        /*return ($this->get('manual_forward')
                     ->handleForward( $this->request, $bundleName = 'IndexBundle', $classNameValue, $functionName = 'index', $this->data));
*/

        $this->response = $this->forward('IndexBundle:Blog:index', [
            'data' => $this->data,
            'ajax' => true
        ]);

    }
}
