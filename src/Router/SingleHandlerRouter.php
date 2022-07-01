<?php

declare(strict_types=1);

namespace Chronhub\Messager\Router;

use Chronhub\Messager\Message\Message;
use Chronhub\Messager\Exceptions\ReportingMessageFailed;
use function count;

final class SingleHandlerRouter implements Router
{
    public function __construct(private Router $router)
    {
    }

    public function route(Message $message): iterable
    {
        $messageHandlers = $this->router->route($message);

        if (1 !== count($messageHandlers)) {
            throw ReportingMessageFailed::oneMessageHandlerOnly();
        }

        return $messageHandlers;
    }
}
