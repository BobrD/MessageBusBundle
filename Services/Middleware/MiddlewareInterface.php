<?php

namespace BobrD\MessageBusBundle\Services\Middleware;

use BobrD\MessageBusBundle\Services\Message\MessageInterface;

interface MiddlewareInterface
{
    /**
     * Wrap handle flow.
     *
     * @param MessageInterface $message
     * @param callable         $next
     */
    public function handle(MessageInterface $message, callable $next);
}
