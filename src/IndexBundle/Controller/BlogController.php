<?php

namespace IndexBundle\Controller;

use IndexBundle\Libs\AbsBootstrap;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use IndexBundle\Repository\BlogRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use IndexBundle\Entity\Blog;
use Symfony\Component\HttpFoundation\Request;
/**
 * Class BlogController
 * Route("/blog")
 */
class BlogController extends AbsBootstrap
{
    public $blog;
    public $blogs;
    public $lastBlog;
    public $lastImage = array ();

    public function run($center) {
        return $this->bootstrapRun($center);
    }

    /**
     * @Route("/blog", name="blog")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {

        $this->blogs = $this->getDoctrine()
        ->getRepository('IndexBundle:Blog')
        ->getCount();

        return new Response(print_r($this->blogs));

    }
}
