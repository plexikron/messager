<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Decorator;

use Chronhub\Messager\Message\Header;
use Chronhub\Messager\Message\Message;

final class MarkAsync implements MessageDecorator
{
    public function decorate(Message $message): Message
    {
        if (! $message->isMessaging()) {
            return $message;
        }

        if ($message->hasNot(Header::ASYNC_MARKER->value)) {
            $message = $message->withHeader(Header::ASYNC_MARKER->value, false);
        }

        return $message;
    }
}
