<?php

namespace BobrD\MessageBusBundle\Services\Bus;

use BobrD\MessageBusBundle\Services\Message\AsyncMessage;
use BobrD\MessageBusBundle\Services\Message\MessageInterface;
use BobrD\MessageBusBundle\Services\Middleware\MiddlewareChain;
use BobrD\MessageBusBundle\Services\Middleware\MiddlewareInterface;

class MessageBusWithMiddleware extends AbstractMessageBus
{
    /**
     * @var MiddlewareInterface[]
     */
    private $middlewares = [];

    /**
     * @param MiddlewareInterface $middleware
     */
    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @param MiddlewareInterface[] $middlewares
     */
    public function setMiddlewares(array $middlewares)
    {
        $this->middlewares = [];

        foreach ($middlewares as $middleware) {
            $this->addMiddleware($middleware);
        }
    }

    /**
     * @param MiddlewareInterface $middleware
     */
    public function removeMiddleware(MiddlewareInterface $middleware)
    {
        $index = array_search($middleware, $this->middlewares);

        if (false !== $index) {
            unset($this->middlewares[$index]);
        }
    }

    /**
     * Handle message in async mode.
     *
     * @param MessageInterface $message
     */
    public function handleAsync(MessageInterface $message)
    {
        $this->messageQueue->add(new AsyncMessage($message, $this->middlewares));
    }

    /**
     * Sync handle message and return payload returned by handler.
     *
     * @param MessageInterface $message
     *
     * @return mixed
     */
    public function handle(MessageInterface $message)
    {
        $handler = $this->getHandler($message);

        return (new MiddlewareChain($this->middlewares, $handler))->handle($message);
    }
}
