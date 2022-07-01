<?php

declare(strict_types=1);

namespace Chronhub\Messager\Tracker;

final class TrackMessage implements MessageTracker
{
    use HasTracker;

    public function newContext(string $event): ContextualMessage
    {
        return new Topic($event);
    }
}
