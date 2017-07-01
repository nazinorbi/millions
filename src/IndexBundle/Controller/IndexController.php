<?php
/**
 * Created by PhpStorm.
 * User: nazi
 * Date: 2016.06.08.
 * Time: 11:24
 */

namespace IndexBundle\Controller;

use IndexBundle\_Interface\HeadCreaturInterface;
use IndexBundle\Libs\AbsBootstrap;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* Controller used to manage blog contents in the public part of the site.
 *
 * @Route("/index")
 * @Route("/")
*
 */
class IndexController extends AbsBootstrap implements HeadCreaturInterface {

    private $data;
    private $text;
    private $sqlResponse = null;

    public function run($center) {
        return $this->bootstrapRun($center);
    }
    /**
     * @Route("/", name="index")
     * @Method({"GET", "POST"})
     */
    public function indexAction($data = null, $ajax = false, Request $request)
    {
        $this->data = $data;
        $this->request = $this->data->url ?? $request->get('_route');
        $this->text = $this->getDoctrine()
            ->getRepository('IndexBundle:Index')
            ->getText();

        $visiable_ = false;

        if(isset($_SESSION['user']) && $_SESSION['user']->userRank == 'owen') {
            $visiable_ = true;
        }

        if($ajax) {
            $this->updateIndexData();
        }
        if($ajax && $this->sqlResponse) {
            return new Response(json_encode(['sqlResponse' => true, 'text' => $this->text]));
        }
        elseif($this->sqlResponse !== true && $ajax) {
            return new JsonResponse(['sqlResponse', $this->sqlResponse]);
        }
        else {
            return $this->run($this->renderView('index.twig', [
                'textEdior' => $this->get('translator')->trans('TEXT_EDITOR'),
                'visiable' => $visiable_,
                'text'  => $this->text->szoveg
            ]));
        }
    }

    private function updateIndexData() {
        $em = $this->getDoctrine()->getManager();

        $this->sqlResponse = $em->getRepository('IndexBundle:Index')->updateIndex($this->data->indexText);
    }
}