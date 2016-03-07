<?php

namespace BobrD\MessageBusBundle\Services\Queue;

use BobrD\MessageBusBundle\Services\Message\AsyncMessageInterface;

interface MessageQueueInterface
{
	/**
	 * @param AsyncMessageInterface $message
	 * 
	 * @return void
	 */
	public function add(AsyncMessageInterface $message);
}
