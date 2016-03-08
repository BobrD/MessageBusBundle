<?php

namespace BobrD\MessageBusBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddHandlerPass implements CompilerPassInterface
{
    const TAG_NAME = 'message_bus.handle';

    /**
     * @param ContainerBuilder $container
     * 
     * @throws \InvalidArgumentException
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('message_bus.base_handler_resolver')) {
            return;
        }

        $handlerResolver = $container->findDefinition('message_bus.base_handler_resolver');

        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $serviceId => $tags) {
            foreach ($tags as $attributes) {
                if (!isset($attributes['command'])) {
                    throw new \InvalidArgumentException('Tag "'.self::TAG_NAME.'" should have "command" attribute.');
                }

                $handlerResolver->addMethodCall('addHandler', [
                    $attributes['command'],
                    new Reference($serviceId),
                ]);
            }
        }
    }
}
