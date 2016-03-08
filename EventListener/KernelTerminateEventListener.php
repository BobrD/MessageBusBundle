<?php

namespace BobrD\MessageBusBundle\EventListener;

use BobrD\MessageBusBundle\Services\Queue\LazyMessageQueue;

class KernelTerminateEventListener
{
    /**
     * @var LazyMessageQueue
     */
    private $kernelTerminateMessageQueue;

    /**
     * @param LazyMessageQueue $kernelTerminateMessageQueue
     */
    public function __construct(LazyMessageQueue $kernelTerminateMessageQueue)
    {
        $this->kernelTerminateMessageQueue = $kernelTerminateMessageQueue;
    }

    /**
     * Start handle all messages.
     */
    public function onKernelTerminate()
    {
        $this->kernelTerminateMessageQueue->handleAll();
    }
}
