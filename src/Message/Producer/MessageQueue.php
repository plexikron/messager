<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Producer;

use Chronhub\Messager\Message\Message;

interface MessageQueue
{
    public function toQueue(Message $message): void;
}
