<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Decorator;

use Chronhub\Messager\Message\Header;
use Chronhub\Messager\Message\Message;
use function get_class;

final class MarkEventType implements MessageDecorator
{
    public function decorate(Message $message): Message
    {
        if ($message->hasNot(Header::EVENT_TYPE->value)) {
            $message = $message->withHeader(Header::EVENT_TYPE->value, get_class($message->event()));
        }

        return $message;
    }
}
