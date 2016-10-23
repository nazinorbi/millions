<?php

namespace IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * User
 * @ORM\Entity(repositoryClass="IndexBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 * IgnoreAnnotation("fn")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="Id")
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="user_name")
     */
    private $userName;

    /**
     * @ORM\Column(type="string", name="userEmail")
     */
    private $userEmail;

    /**
     * @ORM\Column(type="string", name="userActive")
     */
    private $userActive;
    /**
     * @ORM\Column(type="string", name="userPassword")
     */
    private $userPassword;

    /**
     * @ORM\Column(type="string", name="userNicname")
     */
    private $userNicname;

    /**
     * @ORM\Column(type="string", name="userRank")
     */
    private $userRank;

    /**
     * @ORM\Column(type="string", name="avatarpath")
     */
    private $avatarpath;

    /**
     * @ORM\Column(type="string", name="userFailedLogins")
     */
    private $userFailedLogins;

    /**
     * @ORM\Column(type="string", name="userLastFailedLogin")
     */
    private $userLastFailedLogin;

    public function getId()
    {
        return $this->id;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this->userName;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getUserEmail()
    {
        return $this->userEmail;
    }

    public function getUserPasworld()
    {
        return $this->userPassword;
    }
}

