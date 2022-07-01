<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Producer;

use Chronhub\Messager\Message\Message;
use Chronhub\Messager\Message\AsyncMessage;

final class PerMessageProducer extends ProduceMessage
{
    protected function isSyncWithStrategy(Message $message): bool
    {
        return ! $message->event() instanceof AsyncMessage;
    }
}
