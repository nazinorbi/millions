<?php
namespace IndexBundle\Entity;

/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2017. 02. 04.
 * Time: 9:24
 */

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 * @ORM\Entity(repositoryClass="IndexBundle\Repository\ZarasRepository")
 * @ORM\Table(name="zaras")
 * IgnoreAnnotation("fn")
 */
class Zaras {
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

    /**
     * @ORM\Column(type="string", name="osszeg")
     */
    public $osszeg;

    public function getId() {
        return $this->id;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function getOsszeg() {
       return $this->osszeg;
    }

    public function setOsszeg($osszeg) {
        $this->osszeg = $osszeg;
    }
    public function setDatum($datum) {
        $this->datum = $datum;
    }

}