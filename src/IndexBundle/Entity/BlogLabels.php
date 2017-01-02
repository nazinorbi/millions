<?php
/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2017. 01. 02.
 * Time: 20:13
 */

namespace IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Blog
 * @ORM\Entity(repositoryClass="IndexBundle\Repository\BlogLabelsRepository")
 * @ORM\Table(name="blogLabels")
 * IgnoreAnnotation("fn")
 */
class BlogLabel
{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    public $id;

    /**
     * @ORM\Column(type="string", name="name")
     */
    public $name;

    /**
     * @ORM\Column(type="string", name="slug")
     */
    public $slug;

    public function getName() {
        return $this->name;
    }

    public function getSlug() {
        return $this->slug;
    }
}