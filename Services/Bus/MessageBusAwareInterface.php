<?php

namespace BobrD\MessageBusBundle\Services\Bus;

interface MessageBusAwareInterface
{
    /**
     * @param MessageBusInterface $messageBus
     */
    public function setMessageBus(MessageBusInterface $messageBus);
}
