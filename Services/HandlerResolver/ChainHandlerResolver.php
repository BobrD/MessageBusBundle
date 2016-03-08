<?php

namespace BobrD\MessageBusBundle\Services\HandlerResolver;

use BobrD\MessageBusBundle\Services\Handler\HandlerInterface;
use BobrD\MessageBusBundle\Services\Message\MessageInterface;

class ChainHandlerResolver implements HandlerResolverInterface
{
    /**
     * @var HandlerResolverInterface[]
     */
    private $resolvers = [];

    /**
     * @param HandlerResolverInterface $handlerResolver
     */
    public function addResolver(HandlerResolverInterface $handlerResolver)
    {
        $this->resolvers[] = $handlerResolver;
    }

    /**
     * @param MessageInterface $message
     *
     * @return HandlerInterface|null
     */
    public function resolve(MessageInterface $message)
    {
        foreach ($this->resolvers as $resolver) {
            $handler = $resolver->resolve($message);

            if (null !== $handler) {
                return $handler;
            }
        }
    }
}
