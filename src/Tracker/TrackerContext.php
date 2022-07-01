<?php

declare(strict_types=1);

namespace Chronhub\Messager\Tracker;

use Throwable;

interface TrackerContext
{
    public function withEvent(string $event): void;

    public function currentEvent(): string;

    public function stopPropagation(bool $stopPropagation): void;

    public function isPropagationStopped(): bool;

    public function withRaisedException(Throwable $exception): void;

    public function exception(): ?Throwable;

    public function resetException(): bool;

    public function hasException(): bool;
}
