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
    private  $zarWaring = 'false';

    /**
     * @Route("/ajax", name="ajax")
     * @Method({"GET", "POST"})
     */
    public function ajaxAction(Request $request)  {

        $this->request = $request;

        $this->data = (object)($request->request->get('data'));
        $instance = $request->request->get('instance') ?? $request->get('_route');
        $this->data->url = $instance ?? $request->get('_route');
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
            case 'kassza':
                $this->controllerCall('Kassza');
                break;
            case 'kuszob':
                $this->getDoctrine()->getRepository('IndexBundle:Kuszob')
                    ->updateKuszob($this->data->kuszob);
                break;
            case 'kategoria':
                $this->kategoria();
                break;
            case 'zarReport':
                $this->zarReport();
                break;
            case 'bevKiadReport':
                $this->bevKiadReport();
                break;
            case 'checkTransNum':
                $this->controllerCall('Index');
                break;
            default:
                  $this->controllerCall($instance);
               /* if($request instanceof Response) {
                    echo 'fhfxgsd';
                    return $request;
                }*/

             break;
        }

        return new Response($this->response);
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
        $this->response = $this->forward('IndexBundle:'.ucfirst($classNameValue).':index', [
            'data' => $this->data,
            'ajax' => true
        ])->getContent();

    }

    public function kategoria() {
        if($this->data->action == 'insert') {
            $katObj = new Kategoria();

            $katObj->kateg = $this->data->kategoria;

            $em = $this->getDoctrine()->getManager();
            $em->persist($katObj);
            $em->flush();
        }
        elseif ($this->data->action == 'delete') {
            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('IndexBundle:Kategoria');

            $product = $repository->findOneBy(array('id' => $this->data->katId));
            $em->remove($product);
            $em->flush();
        }
    }

    public function zarReport() {
        $query = $this->getDoctrine()->getRepository('IndexBundle:Zaras')
            ->getBeatwinZaras($this->data->whereStart, $this->data->whereEnd);

        if(empty($query)) {
            $this->zarWaring = 'true';
        }

        $this->response = $this->renderView('zarReport.twig', [
            'zaras' => $query['osszeg'],
            'datum' => $query['datum'],
            'zarWaring' => $this->zarWaring,
            'start' => $this->data->whereStart,
            'end' => $this->data->whereEnd
        ]);

    }

    public function bevKiadReport() {
        $bevKiadReportWaring = 'false';
        $kateg = $this->data->kateg ?? false;

        if($this->data->bevKiadType == 0) {
            $query = $this->getDoctrine()->getRepository('IndexBundle:Bevetel')
                ->getBevetel($this->data->start, $this->data->end, $kateg);

            if(empty($query)) {
                $bevKiadReportWaring = 'true';
            }

            $this->response = $this->renderView('bevKiadReport.twig', [
                'reports' => $query,
                'bevKiadReportWaring' => $bevKiadReportWaring
            ]);
        } else {
            $query = $this->getDoctrine()->getRepository('IndexBundle:Kiadas')
                ->getKiadas($this->data->start, $this->data->end, $this->data->kateg);

            if(empty($query)) {
                $bevKiadReportWaring = 'true';
            }

            $this->response = $this->renderView('bevKiadReport.twig', [
                'reports' => $query,
                'bevKiadReportWaring' => $bevKiadReportWaring
            ]);
        }
    }
}
