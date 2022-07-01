<?php

declare(strict_types=1);

namespace Chronhub\Messager\Router;

use Chronhub\Messager\Message\Message;

interface Router
{
    public function route(Message $message): iterable;
}
