<?php

namespace BobrD\MessageBusBundle\Services\HandlerResolver;

use BobrD\MessageBusBundle\Services\Handler\HandlerInterface;
use BobrD\MessageBusBundle\Services\Message\MessageInterface;

class BaseHandlerResolver implements HandlerResolverInterface
{
    /**
     * @var HandlerInterface[]
     */
    private $handlers = [];

    /**
     * @param string           $messageClassName
     * @param HandlerInterface $handler
     */
    public function addHandler($messageClassName, HandlerInterface $handler)
    {
        $this->handlers[$messageClassName] = $handler;
    }

    /**
     * @param MessageInterface $message
     * 
     * @return HandlerInterface|null
     */
    public function resolve(MessageInterface $message)
    {
        $messageClassName = get_class($message);

        if (isset($this->handlers[$messageClassName])) {
            return $this->handlers[$messageClassName];
        }

        return;
    }
}
