<?php

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\DependencyInjection;

use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\Session;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\SessionInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class ShapecodeDoctrineSessionHandlerExtension
 *
 * @package Shapecode\Bundle\Doctrine\SessionHandlerBundle\DependencyInjection
 * @author  Nikita Loges
 */
class ShapecodeDoctrineSessionHandlerExtension extends Extension implements PrependExtensionInterface
{

    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));;
        $loader->load('services.yml');
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $doctrine = [
            'orm' => [
                'resolve_target_entities' => [
                    SessionInterface::class => Session::class,
                ]
            ]
        ];

        $container->prependExtensionConfig('doctrine', $doctrine);
    }
}
