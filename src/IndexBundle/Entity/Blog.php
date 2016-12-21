<?php
namespace IndexBundle\Entity;

/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2016. 12. 13.
 * Time: 10:34
 */

use Doctrine\ORM\Mapping as ORM;

/**
 * Blog
 * @ORM\Entity(repositoryClass="IndexBundle\Repository\BlogRepository")
 * @ORM\Table(name="blog_html")
 * IgnoreAnnotation("fn")
 */

class Blog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="Id")
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="postDate")
     */
   /// private $postDate;

    /**
     * @ORM\Column(type="string", name="prolog")
     */
    private $prolog;

    /**
     * @ORM\Column(type="string", name="blog")
     */
    private $blog;

    /**
     * @ORM\Column(type="string", name="title")
     */
    private $title;

    /**
     * @ORM\Column(type="string", name="author")
     */
    private $author;

    /**
     * @ORM\Column(type="string", name="label")
     */
    private $label;

    /**
     * @ORM\Column(type="string", name="imagePath")
     */
    private $imagePath;

    /**
     * @ORM\Column(type="string", name="post_status")
     */
    private $post_status;

    /**
     * @ORM\Column(type="string", name="comment_status")
     */
    private $comment_status;

    public function getId() {
        return $this->id;
    }

   /* public function getpostDate() {
        return $this->postDate;
    }*/

    public function getProlog() {
        return $this->prolog;
    }

    public function getBlog() {
        return $this->blog;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function getPostStatus() {
        return $this->post_status;
    }

    public function getCommentStatus() {
        return $this->comment_status;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setProlog($prolog) {
        $this->prolog = $prolog;
    }
}