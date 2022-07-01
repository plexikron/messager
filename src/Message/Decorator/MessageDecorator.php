<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Decorator;

use Chronhub\Messager\Message\Message;

interface MessageDecorator
{
    public function decorate(Message $message): Message;
}
