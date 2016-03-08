<?php

namespace BobrD\MessageBusBundle\Services\Bus;

trait MessageBusAwareTrait
{
    /**
     * @var MessageBusInterface
     */
    protected $messageBus;

    /**
     * @param MessageBusInterface $messageBus
     */
    public function setMessageBus(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }
}
