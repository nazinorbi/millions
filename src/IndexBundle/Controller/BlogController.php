<?php

namespace IndexBundle\Controller;

use IndexBundle\Libs\AbsBootstrap;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use IndexBundle\Entity\Blog;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BlogController
 * Route("/blog")
 */
class BlogController extends AbsBootstrap
{
    public $blog;
    private $date = [];
    private $label = [];
    private $total;
    public $lastBlog;
    public $lastImage = array ();
    public $start;
    public $end;
    private $paginateObj;
    private $paginRener;
    private $request;
    private $data;

    public function run($center) {
        return $this->bootstrapRun($center);
    }

    /**
     * @Route("/blog", name="blog")
     * @Method({"GET", "POST"})
     */
    public function indexAction($data = null, $ajax = false, Request $request) {
        $this->data = $data;
         $this->request = $this->data->url ?? $request->get('_route');

        $this->sqlQuery();
        $this->crateRandImage();

        if($ajax) {
            return new Response($this->response(), 200);
        } else {
            return $this->run($this->response());
        }
    }

    public function response() {
        return $this->renderView('blog.twig', [
                'total' => $this->total,
                'pagin' => $this->paginRener,
                'lastBlog' => $this->lastBlog,
                'lastImage' => $this->lastImage(),
                'blogs' => $this->blog,
                "date" => $this->dateTimeConvert(),
                "labels" => $this->blogsLabel($this->blog),
                "rank" => $_SESSION['user']->user->userRank ?? false
        ]);
    }
    public function sqlQuery() {
        $this->total = $this->getDoctrine()
            ->getRepository('IndexBundle:Blog')
            ->getCount();

        $this->lastBlog = $this->getDoctrine()
            ->getRepository('IndexBundle:Blog')
            ->getLastBlog();

        $this->paginate($this->total, $this->data, $this->request);

        $this->blog = $this->getDoctrine()
            ->getRepository('IndexBundle:Blog')
            ->getBlog($this->paginateObj->startRange, $this->paginateObj->endRange);
    }

    public function lastImage() {
        preg_match_all('/http:\/\/[a-zA-Z\d.-_\/]*.jpg/', $this->lastBlog->blog, $result );
        $randNumber = rand ( 0, count ( $result ) - 1 );

        return isset($result[$randNumber][0]) ?? false;
    }

    public function paginate($total, $data, $request) {


        if(!empty($data) && isset($data->page)) {
            $parameters = [
                'totalItems' => (int)$total,
                'current_page' => $data->page,
                'items_per_page' => $data->ipp
            ];
        } else {
            $parameters = [
                'totalItems' => (int)$total
            ];
        }

        $this->paginateObj = $this->get('paginate')->paginate($parameters, $request);

        $this->paginRener =  $this->renderView('Paginator.twig', [
            'pagin' => $this->objectToArray($this->paginateObj)
        ]);
    }

    public function objectToArray($data)
    {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        if (is_array($data)) {
            return array_map(array($this, 'objectToArray'), $data);
        }

        return $data;
    }

    public function dateTimeConvert() {

        foreach ($this->blog as $index => $blog) {
            $this->date[$index] = (string)date_format($blog->postModified,("Y-m-d"));
        }

        return $this->date;
    }

    private function blogsLabel($blogs) {

        if(empty($this->blog->label)) {
            return false;
        }
        $labelJson = null;
        $labels = null;

        foreach ($blogs as $index => $blog) {
            $labelJson[$index] = $blog->label;
        }

        foreach ($labelJson as $index => $label) {
            $labels[$index] = $this->blogLabelCreate($label);
        }

        return $labels;
    }

    private function blogLabelCreate($labelsJson) {
        $labels = null;

        foreach (json_decode($labelsJson, true) as $index => $label){
            $labels[$index] = (
            $this->getDoctrine()
                ->getRepository('IndexBundle:BlogLabels')
                ->getTitle($label)
            );
        }

        return $labels;
    }

    private function crateRandImage() {
        $dataBasePath = null;
        $repaced = null;
        $decoded = null;

        foreach ($this->blog as $index => $blog) {
            if(!empty($blog->imagePath)) {
                $dataBasePath = stripslashes($this->blog[$index]->imagePath);

                $repaced = str_replace("Store", "web/Image/Store", $dataBasePath);
                $decoded = json_decode($repaced, true);

                $this->blog[$index]->imagePath = $this->randImage($decoded);
            } else {
                preg_match_all('/http:\/\/[a-zA-z\d._\-\/]*.jpg/', $blog->blog, $decoded);

                $this->blog[$index]->imagePath = !empty($decoded[0]) ? $this->randImage($decoded[0]) : false;
            }
        }
    }

    private function randImage(array $image) {
        $number = rand ( 0, count($image) - 1 );

        return $image[$number] ?? false;
    }
}
