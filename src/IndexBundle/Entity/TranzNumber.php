<?php
namespace IndexBundle\Entity;
/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2017. 02. 10.
 * Time: 9:41
 */

use Doctrine\ORM\Mapping as ORM;

/**
 * Bevetek
 * @ORM\Entity(repositoryClass="IndexBundle\Repository\TranzNumberRepository")
 * @ORM\Table(name="tranznumber")
 * IgnoreAnnotation("fn")
 */
class TranzNumber
{
    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    public $id;

    /**
     * @ORM\Column(type="integer", name="tranzNumber")
     */
    public $tranzNumber;

    /**
     * @ORM\Column(type="integer", name="bevNumber")
     */
    public $bevNumber;

    /**
     * @ORM\Column(type="integer", name="kiadNumber")
     */
    public $kiadNumber;

    /**
     * @ORM\Column(type="integer", name="sumTranz")
     */
    public $sumTranz;

    /**
     * @ORM\Column(type="string", name="datum")
     */
    public $datum;

    public function getId() {
        return $this->id;
    }

    public function getTranzNumber() {
        return $this->tranzNumber;
    }

    public function getBevNumber() {
        return $this->bevNumber;
    }

    public function getKiadNumber() {
        return $this->kiadNumber;
    }

    public function getSumTranz() {
        return $this->sumTranz;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function setTranzNmber($tranzNumber) {
        $this->tranzNumber = $tranzNumber;
    }

    public function setBevNumber($bevNumber) {
        $this->bevNumber = $bevNumber;
    }

    public function setKiadNUmber($kiadNumber) {
        $this->kiadNumber = $kiadNumber;
    }

    public function setSumNumber($sumTranz) {
        $this->sumTranz = $sumTranz;
    }

    public function setDatum($datum) {
        $this->datum = $datum;
    }
}