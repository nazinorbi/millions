<?php

namespace Tests\Utils;
namespace IndexBundle\Controller;


/**
 * Created by PhpStorm.
 * User: nazi
 * Date: 2016.07.27.
 * Time: 21:21
 */
class FooExtensionTest extends \PHPUnit_Framework_TestCase
{
    private  $container;

    public function __construct()
    {
        require_once __DIR__ . '/../../../../app/AppKernel.php';

        $this->app = new \AppKernel('dev', true);
        $this->app->boot();
        $this->container = $this->app->getContainer();
    }

    public function testGetFoo() {
        $result = $this->container->get('foo_extension')->getFoo();;

        $this->assertEquals($result,'HelóóóókaHahó!!!987');
    }
}
