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
 * Kategoria
 * @ORM\Entity(repositoryClass="IndexBundle\Repository\KategoriaRepository")
 * @ORM\Table(name="kategoria")
 * IgnoreAnnotation("fn")
 */
Class Kategoria {

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    public $id;

    /**
     * @ORM\Column(type="string", name="kateg")
     */
    public $kateg;

    public function getId() {
        return $this->id;
    }

    public function getKateg() {
        return $this->kateg;
    }

    public function setKateg($kateg) {
        $this->kateg = $kateg;
    }

}