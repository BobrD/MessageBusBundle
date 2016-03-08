<?php

namespace BobrD\MessageBusBundle\Services\Middleware;

use BobrD\MessageBusBundle\Services\Message\MessageInterface;
use Psr\Log\LoggerInterface;

class LogMiddleware implements MiddlewareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param MessageInterface $message
     * @param callable         $next
     * 
     * @return mixed
     * 
     * @throws \Exception
     */
    public function handle(MessageInterface $message, callable $next)
    {
        try {
            return $next($message);
        } catch (\Exception $e) {
            $this->logger->critical('Throwed exception begin handle message.', ['exception' => $e]);

            throw $e;
        }
    }
}
