<?php

declare(strict_types=1);

namespace Chronhub\Messager\Tracker;

interface MessageTracker extends Tracker
{
    public function newContext(string $event): ContextualMessage;
}
