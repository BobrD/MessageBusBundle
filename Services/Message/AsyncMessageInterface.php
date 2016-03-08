<?php

namespace BobrD\MessageBusBundle\Services\Message;

interface AsyncMessageInterface extends MessageInterface
{
    /**
     * @return MessageInterface
     */
    public function getMessage();

    /**
     * @return MessageInterface[]
     */
    public function getMiddleware();
}
