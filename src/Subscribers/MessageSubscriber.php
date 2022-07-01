<?php

declare(strict_types=1);

namespace Chronhub\Messager\Subscribers;

use Chronhub\Messager\Tracker\MessageTracker;

interface MessageSubscriber extends Subscriber
{
    public function attachToTracker(MessageTracker $tracker): void;
}
