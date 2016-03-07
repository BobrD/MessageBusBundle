<?php

namespace BobrD\MessageBusBundle\Services;

use BobrD\MessageBusBundle\Services\Message\MessageInterface;
use BobrD\MessageBusBundle\Services\Middleware\MiddlewareInterface;

interface MessageBusInterface
{
	/**
	 * Handle message in async mode.
	 *
	 * @param MessageInterface $message
	 * @param MiddlewareInterface[] $middlewares
	 * 
	 * @return void
	 */
	public function handleAsync(MessageInterface $message, array $middlewares = []);

	/**
	 * Sync handle message and return payload returned by handler.
	 *
	 * @param MessageInterface $message
	 * @param MiddlewareInterface[] $middlewares
	 * 
	 * @return mixed
	 */
	public function handle(MessageInterface $message, array $middlewares = []);
}
