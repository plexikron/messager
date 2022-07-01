<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Decorator;

use Chronhub\Messager\Message\Message;

final class ChainMessageDecorators implements MessageDecorator
{
    private array $messageDecorators;

    public function __construct(MessageDecorator ...$messageDecorators)
    {
        $this->messageDecorators = $messageDecorators;
    }

    public function decorate(Message $message): Message
    {
        foreach ($this->messageDecorators as $messageDecorator) {
            $message = $messageDecorator->decorate($message);
        }

        return $message;
    }
}
