<?php

declare(strict_types=1);

namespace Chronhub\Messager\Tracker;

final class GenericListener implements Listener
{
    /**
     * @var callable
     */
    private $callback;

    public function __construct(public readonly string $event,
                                callable $callback,
                                public readonly int $priority)
    {
        $this->callback = $callback;
    }

    public function handle(TrackerContext $context): void
    {
        ($this->callback)($context);
    }

    public function eventName(): string
    {
        return $this->event;
    }

    public function priority(): int
    {
        return $this->priority;
    }
}
