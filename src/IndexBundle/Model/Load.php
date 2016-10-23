<?php
/**
 * Created by PhpStorm.
 * User: nazi
 * Date: 2016.08.15.
 * Time: 19:23
 */

namespace IndexBundle\Model;

use Symfony\Component\DependencyInjection\Container;

class Load {

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function load() {
       echo $this->container->get('templating')->render(
            'index.html.twig');
    }

    public  function  head() {
        echo $this->container->get('templating')->render(
            'head.twig');
    }

    public function main() {
        echo $this->container->get('templating')->render(
            'main.twig');
    }

    public function header() {
        echo $this->container->get('templating')->render(
            'header.twig');
    }

    public function nav() {
        echo $this->container->get('templating')->render(
            'nav.twig');
    }

    public function center() {
        echo $this->container->get('templating')->render(
            'center.twig');
    }

    public  function leftSide() {
        echo $this->container->get('templating')->render(
            'leftSide.twig');
    }

    public function centerSide() {
        echo $this->container->get('templating')->render(
            'centerSide.twig');
    }

    public function rightSide() {
        echo $this->container->get('templating')->render(
            'rightSide.twig');
    }

    public function footer() {
        echo $this->container->get('templating')->render(
            'footer.twig');
    }
}