<?php

declare(strict_types=1);

namespace Chronhub\Messager\Tracker;

use Generator;
use React\Promise\PromiseInterface;
use Chronhub\Messager\Message\Message;

interface ContextualMessage extends TrackerContext
{
    public function withTransientMessage(object|array $transientMessage): void;

    public function withMessage(Message $message): void;

    public function withMessageHandlers(iterable $messageHandlers): void;

    public function withPromise(PromiseInterface $promise): void;

    public function markMessageHandled(bool $isMessageHandled): void;

    public function isMessageHandled(): bool;

    public function messageHandlers(): Generator;

    public function message(): Message;

    public function transientMessage(): null|object|array;

    public function pullTransientMessage(): object|array;

    public function promise(): ?PromiseInterface;
}
