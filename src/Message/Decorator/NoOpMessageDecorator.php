<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Decorator;

use Chronhub\Messager\Message\Message;

final class NoOpMessageDecorator implements MessageDecorator
{
    public function decorate(Message $message): Message
    {
        return $message;
    }
}
