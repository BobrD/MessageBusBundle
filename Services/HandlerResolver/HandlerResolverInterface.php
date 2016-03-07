<?php

namespace BobrD\MessageBusBundle\Services\HandlerResolver;

use BobrD\MessageBusBundle\Services\Handler\HandlerInterface;
use BobrD\MessageBusBundle\Services\Message\MessageInterface;

interface HandlerResolverInterface
{
	/**
	 * @param MessageInterface $message
	 * 
	 * @return HandlerInterface|null
	 */
	public function resolve(MessageInterface $message);
}