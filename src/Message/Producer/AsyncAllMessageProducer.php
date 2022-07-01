<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Producer;

use Chronhub\Messager\Message\Message;

final class AsyncAllMessageProducer extends ProduceMessage
{
    protected function isSyncWithStrategy(Message $message): bool
    {
        return false;
    }
}
