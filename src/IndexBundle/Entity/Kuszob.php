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
 * Kuszob
 * @ORM\Entity(repositoryClass="IndexBundle\Repository\KuszobRepository")
 * @ORM\Table(name="kuszob")
 * IgnoreAnnotation("fn")
 */
Class Kuszob {

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    public $id;

    /**
     * @ORM\Column(type="string", name="kuszob")
     */
    public $kuszob;

    public function getId() {
        return $this->id;
    }

    public function getKuszob() {
        return $this->kuszob;
    }

    public function setKuszob($kuszob) {
        $this->kuszob = $kuszob;
    }
}