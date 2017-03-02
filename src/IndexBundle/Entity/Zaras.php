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
 * Zaras
 *
 * @ORM\Entity(repositoryClass="IndexBundle\Repository\ZarasRepository")
 * @ORM\Table(name="zaras")
 * IgnoreAnnotation("fn")
 */
class Zaras {

    /**
     * @var integer
     *
     * @ORM\Column(type="integer",name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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

    /**
     * Get id
     *
     * @return integer
     */
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