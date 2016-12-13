<?php
/**
 * Created by IntelliJ IDEA.
 * User: nazinorbi
 * Date: 2016. 12. 13.
 * Time: 10:34
 */


namespace IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 * @ORM\Entity(repositoryClass="IndexBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 * IgnoreAnnotation("fn")
 */

class Blog
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="blog_id")
     */
    private $blog_id;

    /**
     * @ORM\Clumn(type='datetime', name='post_date')
     */
    private $post_date;

    /**
     * @ORM\Clumn(type='string', name='prolog')
     */
    private $prolog;

    /**
     * @ORM\Clumn(type='string', name='blog')
     */
    private $blog;

    /**
     * @ORM\Clumn(type='string', name='title')
     */
    private $title;

    /**
     * @ORM\Clumn(type='string', name='author')
     */
    private $author;

    /**
     * @ORM\Clumn(type='string', name='label')
     */
    private $label;

    /**
     * @ORM\Clumn(type='string', name='imagePath')
     */
    private $imagePath;

    /**
     * @ORM\Clumn(type='string', name='post_status')
     */
    private $post_status;

    /**
     * @ORM\Clumn(type='string', name='comment_status')
     */
    private $comment_status;

}