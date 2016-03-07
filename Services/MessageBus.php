<?php

namespace BobrD\MessageBusBundle\Services;

use BobrD\MessageBusBundle\Services\Exception\MessageBusException;
use BobrD\MessageBusBundle\Services\Middleware\MiddlewareChain;
use BobrD\MessageBusBundle\Services\HandlerResolver\HandlerResolverInterface;
use BobrD\MessageBusBundle\Services\Message\AsyncMessage;
use BobrD\MessageBusBundle\Services\Message\MessageInterface;
use BobrD\MessageBusBundle\Services\Queue\MessageQueueInterface;

class MessageBus implements MessageBusInterface
{
	/**
	 * @var MessageQueueInterface
	 */
	private $messageQueue;

	/**
	 * @var HandlerResolverInterface
	 */
	private $handlerResolver;

	/**
	 * @param HandlerResolverInterface $handlerResolver
	 * @param MessageQueueInterface $messageQueue
	 */
	public function __construct(HandlerResolverInterface $handlerResolver, MessageQueueInterface $messageQueue)
	{
		$this->messageQueue = $messageQueue;
		$this->handlerResolver = $handlerResolver;
	}

	/**
	 * {@inheritdoc}
	 */
	public function handleAsync(MessageInterface $message, array $middlewares = [])
	{
		$this->messageQueue->add(new AsyncMessage($message, $middlewares));
	}

	/**
	 * {@inheritdoc}
	 */
	public function handle(MessageInterface $message, array $middlewares = [])
	{
		$handler = $this->handlerResolver->resolve($message);

		if (null === $handler) {
			throw MessageBusException::handlerNotResolved($message);
		}

		return (new MiddlewareChain($middlewares, $handler))->handle($message);
	}
}
