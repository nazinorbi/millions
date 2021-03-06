<?php

namespace IndexBundle\Controller;

use IndexBundle\Libs\AbsBootstrap;
use IndexBundle\Libs\ManualLoader;
use IndexBundle\Libs\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class StratiController
 * Route("/strati")
 */
class StratiController extends AbsBootstrap
{
    private $stratiPath;
    private $maps;

    public function run($center) {
        return $this->bootstrapRun($center);
    }
    /**
     * @Route("/strati", name="strati")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request) {

        $parameters = [
            'totalItems' => 320,
            'midRange' => 7,
            'current_page' => 9,
            'currentOfTotal' => true,
            'items_per_page' => 5,
            'defaultModelName' => 'model_1'
        ];
        $pagin = $this->get('paginate')->paginate($parameters, $request);
        echo $this->renderView('Paginator.twig', [
            'pagin' => $this->objectToArray($pagin)
            ]);

        $this->createPath();

        if (!isset($_POST['data']["StratiMap"])) {

            $this->maps = $this->stratiPath->mollewide;
        }
        if (isset($_POST['data']["StratiMap"]) && $_POST['data']["StratiMap"] == 'Mollewide') {
            $this->maps = $this->stratiPath->mollewide;
        }
        if (isset($_POST['data']["StratiMap"]) && $_POST['data']["StratiMap"] == 'Globes') {
            $this->maps = $this->stratiPath->globe;
        }
        if (isset($_POST['data']["StratiMap"]) && $_POST['data']["StratiMap"] == 'Total') {
            $this->maps = $this->stratiPath->total;
        }

        if(isset($_POST['instance']) && $_POST['instance'] == 'strati') {
            return new JsonResponse(($this->maps));
        } else {
            return $this->run($this->renderView('strati.twig', [
                "path" => $this->maps
            ]));
        }
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

    public function createPath(){
        $loader = new ManualLoader();
        $this->stratiPath = $loader->manualLoad('stratiPath');
    }
}
