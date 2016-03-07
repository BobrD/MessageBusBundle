<?php

namespace BobrD\MessageBusBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddHandlerPass  implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
	{
		if (!$container->has('message_bus.base_handler_resolver')) {
			return;
		}

		$handlerResolver = $container->findDefinition('message_bus.base_handler_resolver');

		foreach ($container->findTaggedServiceIds('message_handler') as $serviceId => $tags) {
			foreach ($tags as $attributes) {
				if (!isset($attributes['command'])) {
					throw new \LogicException('Tag "message_handler" should have "command" attribute.');
				}

				$handlerResolver->addMethodCall('addHandler', [
					$attributes['command'],
					new Reference($serviceId)
				]);
			}
		}
	}
}
