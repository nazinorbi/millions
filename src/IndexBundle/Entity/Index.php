<?php
/**
 * Created by IntelliJ IDEA.
 * User: nazi
 * Date: 2017. 06. 19.
 * Time: 7:34
 */

namespace IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Index
 * @ORM\Entity(repositoryClass="IndexBundle\Repository\IndexRepository")
 * @ORM\Table(name="index")
 * IgnoreAnnotation("fn")
 */
class Index
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="Id")
     */
    private $id;

    /**
     *  @ORM\Column(type="string", name="text")
     */
    private $text;

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }
}