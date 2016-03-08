<?php

namespace BobrD\MessageBusBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddMiddlewarePass implements CompilerPassInterface
{
    const TAG_NAME = 'message_bus.middleware';

    public function process(ContainerBuilder $container)
    {
        if (!$container->has('message_bus')) {
            return;
        }

        $messageBus = $container->findDefinition('message_bus');

        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $serviceId => $tags) {
            $messageBus->addMethodCall('addMiddleware', [
                new Reference($serviceId),
            ]);
        }

        $config = $container->getExtensionConfig('message_bus')[0];

        if (!isset($config['buses'])) {
            return;
        }

        // config user buses
        foreach ($config['buses'] as $busName => $busOptions) {
            foreach ($busOptions['middlewares'] as $middlewareId) {
                $bussServiceId = sprintf('message_bus.%s', $busName);

                $messageBus = $container->findDefinition($bussServiceId);

                $messageBus->addMethodCall('addMiddleware', [
                    new Reference($middlewareId),
                ]);
            }
        }
    }
}
