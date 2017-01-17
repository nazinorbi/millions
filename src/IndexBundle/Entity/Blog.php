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
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    public $id;

    /**
     * @ORM\Column(type="string", name="postDate")
     */
    public $postDate;

    /**
     * @ORM\Column(type="string", name="prolog")
     */
    public $prolog;

    /**
     * @ORM\Column(type="string", name="blog")
     */
    public $blog;

    /**
     * @ORM\Column(type="string", name="title")
     */
    public $title;

    /**
     * @ORM\Column(type="string", name="author")
     */
    public $author;

    /**
     * @ORM\Column(type="string", name="label")
     */
    public $label;

    /**
     * @ORM\Column(type="string", name="imagePath")
     */
    public $imagePath;

    /**
     * @ORM\Column(type="string", name="post_status")
     */
    public $post_status;

    /**
     * @ORM\Column(type="datetime", name="post_modified")
     */
    public $postModified;

    /**
     * @ORM\Column(type="string", name="comment_status")
     */
    public $comment_status;

    /**
     * @ORM\Column(type="string", name="source")
     */
    public $source;


    public function getId() {
        return $this->id;
    }

    public function getpostDate() {
        return $this->postDate;
    }

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

    public function getPostModified() {
        return $this->postModified;
    }

    public function getSource() {
        return $this->source;
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