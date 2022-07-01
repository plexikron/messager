<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Decorator;

use Ramsey\Uuid\Uuid;
use Chronhub\Messager\Message\Header;
use Chronhub\Messager\Message\Message;

final class MarkEventId implements MessageDecorator
{
    public function decorate(Message $message): Message
    {
        if ($message->hasNot(Header::EVENT_ID->value)) {
            $message = $message->withHeader(Header::EVENT_ID->value, Uuid::uuid4()->toString());
        }

        return $message;
    }
}
