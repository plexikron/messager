<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Factory;

use Chronhub\Messager\Message\Message;
use Chronhub\Messager\Message\Serializer\MessageSerializer;
use function is_array;

final class GenericMessageFactory implements MessageFactory
{
    public function __construct(private MessageSerializer $serializer)
    {
    }

    public function createFromMessage(object|array $event): Message
    {
        if (is_array($event)) {
            $event = $this->serializer->unserializeContent($event)->current();
        }

        if ($event instanceof Message) {
            return $event;
        }

        return new Message($event);
    }
}
