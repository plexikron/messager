<?php

declare(strict_types=1);

namespace Chronhub\Messager\Tracker;

use Throwable;

trait HasTopic
{
    protected ?Throwable $exception = null;

    protected bool $isPropagationStopped = false;

    public function __construct(protected ?string $currentEvent)
    {
    }

    public function withEvent(string $event): void
    {
        $this->currentEvent = $event;
    }

    public function currentEvent(): string
    {
        return $this->currentEvent;
    }

    public function stopPropagation(bool $stopPropagation): void
    {
        $this->isPropagationStopped = $stopPropagation;
    }

    public function isPropagationStopped(): bool
    {
        return $this->isPropagationStopped;
    }

    public function withRaisedException(Throwable $exception): void
    {
        $this->exception = $exception;
    }

    public function hasException(): bool
    {
        return $this->exception instanceof throwable;
    }

    public function resetException(): bool
    {
        $exists = $this->hasException();

        $this->exception = null;

        return $exists;
    }

    public function exception(): ?Throwable
    {
        return $this->exception;
    }
}
