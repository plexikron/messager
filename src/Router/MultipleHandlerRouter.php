<?php

declare(strict_types=1);

namespace Chronhub\Messager\Router;

use Chronhub\Messager\Message\Message;

final class MultipleHandlerRouter implements Router
{
    public function __construct(private Router $router)
    {
    }

    public function route(Message $message): iterable
    {
        return $this->router->route($message);
    }
}
