<?php

declare(strict_types=1);

namespace Chronhub\Messager\Subscribers;

use Chronhub\Messager\Reporter;
use Chronhub\Messager\ReporterPriority;
use Chronhub\Messager\Tracker\MessageTracker;
use Chronhub\Messager\Tracker\ContextualMessage;
use Chronhub\Messager\Message\Factory\MessageFactory;

final class MakeMessage implements MessageSubscriber
{
    public function __construct(private MessageFactory $factory)
    {
    }

    public function attachToTracker(MessageTracker $tracker): void
    {
        $tracker->listen(Reporter::DISPATCH_EVENT, function (ContextualMessage $context): void {
            $message = $this->factory->createFromMessage($context->pullTransientMessage());

            $context->withMessage($message);
        }, ReporterPriority::MESSAGE_FACTORY->value);
    }
}
