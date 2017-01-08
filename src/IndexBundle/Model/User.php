<?php
/**
 * Created by IntelliJ IDEA.
 * User: nazi
 * Date: 2016.09.07.
 * Time: 13:09
 */

namespace IndexBundle\Model;

use Symfony\Component\DependencyInjection\Container;

class User
{

    protected $container;
    public $userData;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function setUser($user)
    {
        $this->userData = (object) $user;
    }

    public function getOneUserData($userData)
    {
        return isset($this->userData->$userData) ?? false;
    }

    public  function getUserData() {
        return $this->userData;
    }
}