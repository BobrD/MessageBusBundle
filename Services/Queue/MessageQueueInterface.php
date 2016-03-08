<?php

namespace BobrD\MessageBusBundle\Services\Queue;

use BobrD\MessageBusBundle\Services\Message\AsyncMessageInterface;

interface MessageQueueInterface
{
    /**
     * @param AsyncMessageInterface $message
     */
    public function add(AsyncMessageInterface $message);
}
