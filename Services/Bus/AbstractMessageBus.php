<?php

namespace BobrD\MessageBusBundle\Services\Bus;

use BobrD\MessageBusBundle\Services\Exception\MessageBusException;
use BobrD\MessageBusBundle\Services\Handler\HandlerInterface;
use BobrD\MessageBusBundle\Services\HandlerResolver\HandlerResolverInterface;
use BobrD\MessageBusBundle\Services\Message\AsyncMessage;
use BobrD\MessageBusBundle\Services\Message\MessageInterface;
use BobrD\MessageBusBundle\Services\Queue\MessageQueueInterface;

abstract class AbstractMessageBus implements MessageBusInterface
{
    /**
     * @var MessageQueueInterface
     */
    protected $messageQueue;

    /**
     * @var HandlerResolverInterface
     */
    protected $handlerResolver;

    /**
     * @param HandlerResolverInterface $handlerResolver
     * @param MessageQueueInterface    $messageQueue
     */
    public function __construct(HandlerResolverInterface $handlerResolver, MessageQueueInterface $messageQueue)
    {
        $this->messageQueue = $messageQueue;
        $this->handlerResolver = $handlerResolver;

        if ($messageQueue instanceof MessageBusAwareInterface) {
            $messageQueue->setMessageBus($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function handleAsync(MessageInterface $message)
    {
        $this->messageQueue->add(new AsyncMessage($message));
    }

    /**
     * {@inheritdoc}
     */
    public function handle(MessageInterface $message)
    {
        return $this->getHandler($message)->handle($message);
    }

    /**
     * @param MessageInterface $message
     * 
     * @return HandlerInterface
     * 
     * @throws MessageBusException
     */
    protected function getHandler(MessageInterface $message)
    {
        $handler = $this->handlerResolver->resolve($message);

        if (null === $handler) {
            throw MessageBusException::handlerNotResolved($message);
        }

        if ($handler instanceof MessageBusAwareInterface) {
            $handler->setMessageBus($this);
        }

        return $handler;
    }
}
