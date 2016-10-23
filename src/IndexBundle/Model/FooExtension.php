<?php
/**
 * Created by PhpStorm.
 * User: nazi
 * Date: 2016.07.03.
 * Time: 19:06
 */
namespace IndexBundle\Model;


class FooExtension {

    public $foovalue;

    public function  __construct($foovalue)
    {
        $this->foovalue = $foovalue;
    }


    public function getFoo()
    {
        return ($this->foovalue.'Hahó!!!987');
    }
}