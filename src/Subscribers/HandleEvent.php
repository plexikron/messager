<?php

declare(strict_types=1);

namespace Chronhub\Messager\Subscribers;

use Chronhub\Messager\Reporter;
use Chronhub\Messager\ReporterPriority;
use Chronhub\Messager\Tracker\MessageTracker;
use Chronhub\Messager\Tracker\ContextualMessage;

final class HandleEvent implements MessageSubscriber
{
    public function attachToTracker(MessageTracker $tracker): void
    {
        $tracker->listen(Reporter::DISPATCH_EVENT, function (ContextualMessage $context): void {
            foreach ($context->messageHandlers() as $messageHandler) {
                $messageHandler($context->message()->event());
            }

            $context->markMessageHandled(true);
        }, ReporterPriority::INVOKE_HANDLER->value);
    }
}
