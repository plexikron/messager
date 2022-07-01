<?php

declare(strict_types=1);

namespace Chronhub\Messager\Subscribers;

use Chronhub\Messager\Reporter;
use Chronhub\Messager\ReporterPriority;
use Chronhub\Messager\Tracker\MessageTracker;
use Chronhub\Messager\Tracker\ContextualMessage;
use Chronhub\Messager\Message\Decorator\MessageDecorator;

final class ChainMessageDecoratorSubscriber implements MessageSubscriber
{
    public function __construct(private MessageDecorator $messageDecorator)
    {
    }

    public function attachToTracker(MessageTracker $tracker): void
    {
        $tracker->listen(Reporter::DISPATCH_EVENT, function (ContextualMessage $context): void {
            $context->withMessage(
                $this->messageDecorator->decorate($context->message())
            );
        }, ReporterPriority::MESSAGE_DECORATOR->value);
    }
}
