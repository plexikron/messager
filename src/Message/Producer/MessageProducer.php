<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Producer;

use Chronhub\Messager\Message\Message;

interface MessageProducer
{
    public function produce(Message $message): Message;

    public function isSync(Message $message): bool;
}
