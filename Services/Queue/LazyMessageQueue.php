<?php

namespace BobrD\MessageBusBundle\Services\Queue;

use BobrD\MessageBusBundle\Services\Message\AsyncMessageInterface;
use BobrD\MessageBusBundle\Services\Bus\MessageBusAwareInterface;
use BobrD\MessageBusBundle\Services\Bus\MessageBusAwareTrait;

class LazyMessageQueue implements MessageQueueInterface, MessageBusAwareInterface
{
    use MessageBusAwareTrait;

    /**
     * @var AsyncMessageInterface[]
     */
    private $queue = [];

    /**
     * {@inheritdoc}
     */
    public function add(AsyncMessageInterface $message)
    {
        $this->queue[] = $message;
    }

    /**
     * Start process messages.
     */
    public function handleAll()
    {
        foreach ($this->queue as $asyncMessage) {
            $this->messageBus->handle($asyncMessage->getMessage());
        }
    }
}
