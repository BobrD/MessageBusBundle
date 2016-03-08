<?php

namespace BobrD\MessageBusBundle\Services\Message;

use Ramsey\Uuid\UuidInterface;

interface MessageInterface
{
    /**
     * @return UuidInterface
     */
    public function getUuid();
}
