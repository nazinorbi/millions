<?php
/**
 * Created by PhpStorm.
 * User: nazi
 * Date: 2016.07.03.
 * Time: 18:59
 */

namespace IndexBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\HttpFoundation\Request;
/**
 * @author Oleg Voronkovich <oleg-voronkovich@yandex.ru>
 */
class IndexExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.yml');
        $loader->load('load.yml');
        $loader->load('header.yml');
        $loader->load('menu.yml');
        $loader->load('login.yml');
        $loader->load('user.yml');
        $loader->load('manual_forward.yml');
        $loader->load('paginate.yml');

      //  print $container->get('head')->getHedOk();
  /*      $request = Request::createFromGlobals();
    $c = preg_split("([^a-z]+)", $request->getPathInfo());
        print( $c[1]); */
    }
}