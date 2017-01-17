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
    public $userData = [];
    public $proba;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->proba = 'sdgydv';
    }

    public function setUser($user)
    {
        $this->userData = $user;
    }

    public function getOneUserData($userData)
    {
        return !empty($this->userData->$userData) ? $this->userData->$userData : false;
    }

    public  function getUserData() {
        return $this->userData;
    }
}