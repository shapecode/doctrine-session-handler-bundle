<?php

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class ShapecodeDoctrineSessionHandlerExtension
 *
 * @package Shapecode\Bundle\Doctrine\SessionHandlerBundle\DependencyInjection
 * @author  Nikita Loges
 */
class ShapecodeDoctrineSessionHandlerExtension extends Extension
{
    
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
