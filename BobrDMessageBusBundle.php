<?php

namespace BobrD\MessageBusBundle;

use BobrD\MessageBusBundle\DependencyInjection\BobrDMessageBusExtension;
use BobrD\MessageBusBundle\DependencyInjection\Compiler\AddHandlerPass;
use BobrD\MessageBusBundle\DependencyInjection\Compiler\AddHandlerResolverPass;
use BobrD\MessageBusBundle\DependencyInjection\Compiler\AddMiddlewarePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BobrDMessageBusBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddHandlerPass());
        $container->addCompilerPass(new AddHandlerResolverPass());
        $container->addCompilerPass(new AddMiddlewarePass());
    }

    public function getContainerExtension()
    {
        return new BobrDMessageBusExtension();
    }
}
