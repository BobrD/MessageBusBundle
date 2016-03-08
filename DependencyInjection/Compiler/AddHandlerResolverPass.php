<?php

namespace BobrD\MessageBusBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddHandlerResolverPass implements CompilerPassInterface
{
    const TAG_NAME = 'message_bus.resolver';

    public function process(ContainerBuilder $container)
    {
        if (!$container->has('message_bus.chain_handler_resolver')) {
            return;
        }

        $chainHandlerResolver = $container->findDefinition('message_bus.chain_handler_resolver');

        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $serviceId => $tags) {
            $chainHandlerResolver->addMethodCall('addResolver', [
                new Reference($serviceId),
            ]);
        }
    }
}
