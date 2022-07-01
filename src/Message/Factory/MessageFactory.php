<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Factory;

use Chronhub\Messager\Message\Message;

interface MessageFactory
{
    public function createFromMessage(object|array $event): Message;
}
