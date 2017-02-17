<?php
namespace IndexBundle\Entity;
/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2017. 02. 01.
 * Time: 17:14
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * Kiadas
 * @ORM\Entity(repositoryClass="IndexBundle\Repository\KiadasRepository")
 * @ORM\Table(name="kiadas")
 * IgnoreAnnotation("fn")
 */
Class Kiadas {

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    public $id;

    /**
     * @ORM\Column(type="string", name="datum")
     */
    public $datum;

   /* /**
     * @ORM\Column(type="string", name="kat")

    public $kat;*/

    /**
     * @ORM\Column(type="string", name="post")
     */
    public $post;

    /**
     * @ORM\Column(type="string", name="kiadas")
     */
    public $kiadas;

    /**
     * @ORM\Column(type="integer", name="katId")
     */
    public $katId;

    public function getId() {
        return $this->id;
    }

    public function getDatum() {
        return $this->datum;
    }

   /* public function getKat() {
        return $this->kat;
    }*/

    public function getPost() {
        return $this->post;
    }

    public function getKiadas() {
        return $this->kiadas;
    }

    public function getKatId() {
        return$this->katId;
    }

    public function setDatum($datum) {
        $this->datum = $datum;
    }

    public function setKat($kat) {
        $this->kat = $kat;
    }

    public function setPost($post) {
        $this->post = $post;
    }

    public function setKiadas($kiadas) {
        $this->kiadas = $kiadas;
    }

    /*public function setKatId($katId) {
        $this->katId = $katId;
    }*/
}