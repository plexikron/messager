<?php

declare(strict_types=1);

namespace Chronhub\Messager\Tracker;

interface Tracker
{
    public function listen(string $eventName, callable $eventContext, int $priority = 0): Listener;

    public function listenOnce(string $eventName, callable $eventContext, int $priority = 0): OneTimeListener;

    public function fire(TrackerContext $context): void;

    public function fireUntil(ContextualMessage $contextEvent, callable $callback): void;

    public function forget(Listener $eventSubscriber): void;
}
