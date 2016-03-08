<?php

namespace BobrD\MessageBusBundle\Services\Message;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

trait MessageTrait
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * @return UuidInterface
     */
    public function getUuid()
    {
        if (null === $this->uuid) {
            $this->uuid = Uuid::uuid4();
        }

        return $this->uuid;
    }
}
