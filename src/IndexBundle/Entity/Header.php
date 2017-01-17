<?php

namespace IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Header
 * @ORM\Entity(repositoryClass="IndexBundle\Repository\HeaderRepository")
 * @ORM\Table(name="headerimage")
 * IgnoreAnnotation("fn")
 */

class Header
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="Id")
     */
    private $id;

    /**
     *  @ORM\Column(type="string", name="imagePath")
     */
    private $imagePath;

    /**
     * @ORM\Column(type="string", name="imageRatio")
     */
    private $imageRatio;

    /**
     * @ORM\Column(type="string", name="imageName")
     */
    private $imageName;

    public function getId()
    {
        return $this->id;
    }

    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImageRatio($imageRatio)
    {
        $this->imageRatio = $imageRatio;

        return $this;
    }

    public function getImageRatio()
    {
        return $this->imageRatio;
    }
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageName()
    {
        return $this->imageName;
    }
}

