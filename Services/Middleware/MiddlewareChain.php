<?php

namespace BobrD\MessageBusBundle\Services\Middleware;

use BobrD\MessageBusBundle\Services\Handler\HandlerInterface;
use BobrD\MessageBusBundle\Services\Message\MessageInterface;

class MiddlewareChain
{
    /**
     * @var MiddlewareInterface[]
     */
    private $middlewares;

    /**
     * @var HandlerInterface
     */
    private $handler;

    /**
     * @param MiddlewareInterface[] $middlewares
     * @param HandlerInterface      $handler
     */
    public function __construct(array $middlewares, HandlerInterface $handler)
    {
        $this->middlewares = $middlewares;
        $this->handler = $handler;
    }

    /**
     * @param MessageInterface $message
     * 
     * @return mixed
     */
    public function handle(MessageInterface $message)
    {
        return call_user_func($this->callableForNextMiddleware(0), $message);
    }

    /**
     * @param int $index
     * 
     * @return \Closure
     */
    private function callableForNextMiddleware($index)
    {
        if (!isset($this->middlewares[$index])) {
            return function ($message) {
                return $this->handler->handle($message);
            };
        }

        $middleware = $this->middlewares[$index];

        return function ($message) use ($middleware, $index) {
            return $middleware->handle($message, $this->callableForNextMiddleware($index + 1));
        };
    }
}
