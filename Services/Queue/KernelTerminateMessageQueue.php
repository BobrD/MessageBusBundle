<?php

namespace BobrD\MessageBusBundle\Services\Queue;

use BobrD\MessageBusBundle\Services\HandlerResolver\HandlerResolverInterface;
use BobrD\MessageBusBundle\Services\Message\AsyncMessageInterface;
use BobrD\MessageBusBundle\Services\Middleware\MiddlewareChain;

class KernelTerminateMessageQueue implements MessageQueueInterface
{
	/**
	 * @var AsyncMessageInterface[]
	 */
	private $queue = [];
	
	/**
	 * @var HandlerResolverInterface
	 */
	private $handlerResolver;

	/**
	 * @param HandlerResolverInterface $handlerResolver
	 */
	public function __construct(HandlerResolverInterface $handlerResolver)
	{
		$this->handlerResolver = $handlerResolver;
	}

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
			$message = $asyncMessage->getMessage();
			
			$handler = $this->handlerResolver->resolve($message);

			if (null === $handler) {
				continue;
			}

			(new MiddlewareChain($asyncMessage->getMiddleware(), $handler))->handle($message);
		}
	}
}
