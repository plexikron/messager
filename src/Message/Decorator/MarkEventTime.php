<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Decorator;

use Chronhub\Messager\Message\Header;
use Chronhub\Messager\Message\Message;
use Chronhub\Messager\Support\Clock\Clock;

final class MarkEventTime implements MessageDecorator
{
    public function __construct(private Clock $clock)
    {
    }

    public function decorate(Message $message): Message
    {
        if ($message->hasNot(Header::EVENT_TIME->value)) {
            $message = $message->withHeader(Header::EVENT_TIME->value, $this->clock->fromNow()->toString());
        }

        return $message;
    }
}
