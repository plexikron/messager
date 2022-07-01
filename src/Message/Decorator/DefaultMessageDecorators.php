<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Decorator;

use Chronhub\Messager\Message\Message;
use Chronhub\Messager\Support\Clock\Clock;
use Chronhub\Messager\Support\Clock\UniversalSystemClock;

final class DefaultMessageDecorators implements MessageDecorator
{
    public function __construct(private ?Clock $clock = new UniversalSystemClock())
    {
    }

    public function decorate(Message $message): Message
    {
        return (new ChainMessageDecorators(
            new MarkAsync(),
            new MarkEventType(),
            new MarkEventId(),
            new MarkEventTime($this->clock)
        ))->decorate($message);
    }
}
