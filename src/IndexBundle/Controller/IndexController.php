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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


/**
* Controller used to manage blog contents in the public part of the site.
 *
 * @Route("/index")
 * @Route("/")
*
 */
class IndexController extends AbsBootstrap implements HeadCreaturInterface {

    public function run() {
        return $this->bootstrapRun($center = null);
    }
    /**
     * @Route("/", name="index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
        return $this->run();
    }



    public function showAction()
    {
       /* $repository = $this->getDoctrine()
            ->getRepository('IndexBundle:Header');

        $repo = $repository->findAll();*/
    }


}