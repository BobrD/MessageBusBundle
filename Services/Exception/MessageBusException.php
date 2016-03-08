<?php

namespace BobrD\MessageBusBundle\Services\Exception;

use BobrD\MessageBusBundle\Services\Message\MessageInterface;

class MessageBusException extends \Exception
{
    /**
     * @param MessageInterface $message
     * 
     * @return static
     */
    public static function handlerNotResolved(MessageInterface $message)
    {
        return new static(sprintf('Handler for message: "%s" not resolved.', get_class($message)));
    }
}
