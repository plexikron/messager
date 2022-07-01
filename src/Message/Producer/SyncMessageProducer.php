<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Producer;

use Chronhub\Messager\Message\Message;

final class SyncMessageProducer implements MessageProducer
{
    public function produce(Message $message): Message
    {
        return $message;
    }

    public function isSync(Message $message): bool
    {
        return true;
    }
}
