<?php
/**
 * Created by IntelliJ IDEA.
 * User: nazi
 * Date: 2016.09.05.
 * Time: 11:45
 */

namespace IndexBundle\Model;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

class Login {

    protected $container;
    private $em;
    private $errors = [];
    public $userData;

    private $userPassword;
    private $userId;
    protected $translated;

    public function __construct(Container $container, EntityManager $em)
    {
        $this->container = $container;
        $this->em = $em;
        $this->translated = $container->get('translator');
    }

    public function loginRouting($data) {

        if (isset($_SESSION['user']->user->userName) && ($_SESSION['user']->user->userLoggedIn)) {
            //$this->userPassword = $_SESSION ['user']['loginPassworld'];
            $this->sessionEntry();
            return true;
        }
        if(isset($_POST["login"])) {
            $this->userPassword = $_POST ['password'];
            $this->entryUser($_POST ['loginName'], $_POST ['password']);
            $this->pusUserDataToUserObject();
            return true;
        }
        if(isset($_POST['ajax'])) {
            $this->userPassword = $data->loginPass;
            $this->entryUser($data->loginName, $data->loginPass);
            $this->pusUserDataToUserObject();
            return true;
        }
        return false;
    }

    public function entryUser($userName, $userPostPassword, $checkPass = false) {

        if (empty($userName)) {
            $this->errors [] = $this->translated->trans('MESSAGE_USERNAME_EMPTY');
        } else if (empty ($userPostPassword)) {
            $this->errors [] =  $this->translated->trans('MESSAGE_PASSWORD_EMPTY');
        } else {
                $this->userData = $this->em->getRepository('IndexBundle:User')
                    ->getUserFromLogin($userName);
                
                $this->userData->userLoggedIn = true;

            if (!isset($this->userData->id)) {
                $this->errors [] = $this->translated->trans('MESSAGE_LOGIN_FAILED');
            } else if ($this->userData->userFailedLogin >= 3 && $this->userData->userLastFailedLogin > (time() - 30)) {
                $this->errors [] = $this->translated->trans('MESSAGE_PASSWORD_WRONG_3_TIMES');

            } else if (!$this->passwordValidator($this->userPassword, $this->userData->userPassword)) {

                $this->em->getRepository('IndexBundle:User')->failedLogin($userName);

                $this->errors [] = $this->translated->trans('MESSAGE_PASSWORD_WRONG');
            } else if ($this->userData->userActive < 1) {
                $this->errors [] = $this->translated->trans('MESSAGE_ACCOUNT_NOT_ACTIVATED');
            } else if(!$checkPass) {
                // write user data into PHP SESSION [a file on your server]
                $_SESSION['user'] = $this->userData;

                $this->em->getRepository('IndexBundle:User')->succesLogin($this->userId);
                $this->pusUserDataToUserObject();
            }
            else {
                $passworldStatus = empty($this->errors) ? false : true;
                $this->em->getRepository('IndexBundle:User')->succesLogin($this->userId);

                $data = new \stdClass();
                $data->passworldStatus = $passworldStatus;
                $data->error =  $this->errors;

                return $data;
            }
        }
    }

    public function sessionEntry() {
        $this->container->get('user')->setUser($_SESSION['user']);
        $this->userData = $_SESSION['user'];
    }

    public function pusUserDataToUserObject(){
        $this->container->get('user')->setUser($this->userData);
    }

    public function passwordValidator($userPostPassword, $userPassword)
    {
        if ($this->passworldHas($userPostPassword) == $userPassword) {
            return true;
        } else {
            return false;
        }
    }

    public function passworldHas($Password)
    {
        return sha1($Password);
        // return hash('sha512', (sha1($Password . " ") ."millions" . sha1($Password) ));
    }

    // itt twig tér vissza
    public function echoErrorsArray()
    {
        if (!empty ($this->errors)) {
            foreach ($this->errors as $error) {
                echo $error;
            }
        } else {
            return;
        }
    }
}