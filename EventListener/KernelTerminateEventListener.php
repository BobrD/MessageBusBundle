<?php

namespace BobrD\MessageBusBundle\EventListener;

use BobrD\MessageBusBundle\Services\Queue\KernelTerminateMessageQueue;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class KernelTerminateEventListener
{
	/**
	 * @var KernelTerminateMessageQueue
	 */
	private $kernelTerminateMessageQueue;

	/**
	 * @param KernelTerminateMessageQueue $kernelTerminateMessageQueue
	 */
	public function __construct(KernelTerminateMessageQueue $kernelTerminateMessageQueue)
	{
		$this->kernelTerminateMessageQueue = $kernelTerminateMessageQueue;
	}

	/**
	 * Start handle all messages.
	 */
	public function onKernelTerminate(PostResponseEvent $event)
	{
		$this->kernelTerminateMessageQueue->handleAll();
	}
}
