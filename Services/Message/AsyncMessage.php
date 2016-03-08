<?php

namespace BobrD\MessageBusBundle\Services\Message;

class AsyncMessage implements AsyncMessageInterface
{
    /**
     * @var MessageInterface
     */
    private $message;

    /**
     * @var MessageInterface[]
     */
    private $middleware = [];

    /**
     * @param MessageInterface   $message
     * @param MessageInterface[] $middleware
     */
    public function __construct(MessageInterface $message, array $middleware = [])
    {
        $this->message = $message;
        $this->middleware = $middleware;
    }

    /**
     * {@inheritdoc}
     */
    public function getUuid()
    {
        return $this->message->getUuid();
    }

    /**
     * @return MessageInterface
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return MessageInterface[]
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }
}
