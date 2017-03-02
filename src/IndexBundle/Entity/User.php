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
     * @ORM\Column(type="integer", name="id")
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
     * @ORM\Column(type="string", name="userFailedLogin")
     */
    private $userFailedLogin;

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

    public function getUserFailedLogin() {
        return $this->userFailedLogin;
    }

    public function setUserFailedLogin($userFailedLogin) {
        $this->userFailedLogin = $userFailedLogin;
    }

    public function getUserLastFailedLogin() {
        return $this->userLastFailedLogin;
    }

    public function setUserLastFailedLogin($userLastFailedLogin) {
        $this->userLastFailedLogin = $userLastFailedLogin;
    }
}

