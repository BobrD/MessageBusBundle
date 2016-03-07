<?php

namespace BobrD\MessageBusBundle\Services\Handler;

use BobrD\MessageBusBundle\Services\Message\MessageInterface;

interface HandlerInterface
{
	/**
	 * @param MessageInterface $command
	 * 
	 * @return mixed
	 */
	public function handle(MessageInterface $command);
}
