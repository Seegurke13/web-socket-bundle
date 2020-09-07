<?php


namespace Seegurke13\WebSocketBundle\DependencyInjection;


use Symfony\Bundle\FrameworkBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Seegurke13WebSocketExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration($container->getParameter('kernel.debug'));
//        $config = $this->processConfiguration($configuration, $configs);
    }
}