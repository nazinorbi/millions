<?php
/**
 * Created by PhpStorm.
 * User: nazi
 * Date: 2016.08.25.
 * Time: 17:28
 */

namespace IndexBundle\Model;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

class Header {

    private $imageData;
    protected $container;
    private $em;

    public function __construct(Container $container, EntityManager $em)
    {
        $this->container = $container;
        $this->em = $em;
    }

    public function getImageNames($imageRatio)
    {
        $this->getImageData($imageRatio);
        $this->addLocalPath();

        shuffle($this->imageData);
       // print_r($this->imageData[0]);
        return array_slice($this->imageData, 0, 2);
    }

    private function getImageData($imageRatio)
    {

        switch ($imageRatio) {
            case "16:9" :
                $ratioMax = "2.5";
                $ratioMin = "1.5";
                break;
            case "4:3" :
                $ratioMax = "1.499999";
                $ratioMin = "0.75";
                break;
            case "3:4" :
                $ratioMax = "1.5";
                $ratioMin = "0.5";
                break;
            default :
                $ratioMax = "1.5";
                $ratioMin = "2.5";
                break;
        }

        $this->imageData = $this->em->getRepository('IndexBundle:Header')
            ->getHeader($ratioMin, $ratioMax);
    }

    public function addLocalPath() {
        for ($i = 0; $i < count($this->imageData); $i++) {
            if(preg_match('/^Store/', $this->imageData[$i]['imagePath'])) {
                $this->imageData[$i]['imagePath'] = 'web/Image/'.$this->imageData[$i]['imagePath'];
            } else {
                $this->imageData[$i]['imagePath'] = 'web/'.$this->imageData[$i]['imagePath'];
            }

        }
    }
}