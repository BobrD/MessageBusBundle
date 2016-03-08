<?php

namespace BobrD\MessageBusBundle\DependencyInjection;

use BobrD\MessageBusBundle\Services\Bus\MessageBusWithMiddleware;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class BobrDMessageBusExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.xml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['buses'] as $busName => $bussOption) {
            foreach ($bussOption['middlewares'] as $id) {
                $definition = new Definition(MessageBusWithMiddleware::class);

                if (!$container->has($id)) {
                    throw new \InvalidArgumentException(sprintf('Middleware with id "%s" not found.', $id));
                }

                $definition->addMethodCall('addMiddleware', [
                    new Reference($id),
                ]);

                $container->setDefinition(sprintf('message_bus.%s', $busName), $definition);
            }
        }
    }

    public function getAlias()
    {
        return 'message_bus';
    }
}
