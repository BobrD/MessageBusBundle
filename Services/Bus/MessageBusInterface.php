<?php

namespace BobrD\MessageBusBundle\Services\Bus;

use BobrD\MessageBusBundle\Services\Message\MessageInterface;

interface MessageBusInterface
{
    /**
     * Handle message in async mode.
     *
     * @param MessageInterface $message
     */
    public function handleAsync(MessageInterface $message);

    /**
     * Sync handle message and return payload returned by handler.
     *
     * @param MessageInterface $message
     * 
     * @return mixed
     */
    public function handle(MessageInterface $message);
}
