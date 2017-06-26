<?php
namespace IndexBundle\Entity;
/**
 * Created by IntelliJ IDEA.
 * User: nazi
 * Date: 2017. 06. 19.
 * Time: 7:34
 */



use Doctrine\ORM\Mapping as ORM;

/**
 * Index
 * @ORM\Entity(repositoryClass="IndexBundle\Repository\IndexRepository")
 * @ORM\Table(name="index_")
 * IgnoreAnnotation("fn")
 */
class Index
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    private $id;

    /**
     *  @ORM\Column(type="string", name="szoveg",  options={"collate":"utf8_general_ci", "charset":"utf8", "engine":"MyISAM"})
     */
    public $szoveg;

    /**
     * @ORM\Column(type="string", name="datum")
     */
    public $datum;

    public function getId() {
        return $this->id;
    }

    public function getSzoveg() {
        return $this->szoveg;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function setSzoveg($szoveg) {
        $this->szoveg = $szoveg;

        return $this;
    }
}