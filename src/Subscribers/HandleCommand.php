<?php

declare(strict_types=1);

namespace Chronhub\Messager\Subscribers;

use Chronhub\Messager\Reporter;
use Chronhub\Messager\Message\Header;
use Chronhub\Messager\ReporterPriority;
use Chronhub\Messager\Tracker\MessageTracker;
use Chronhub\Messager\Tracker\ContextualMessage;

final class HandleCommand implements MessageSubscriber
{
    public function attachToTracker(MessageTracker $tracker): void
    {
        $tracker->listen(Reporter::DISPATCH_EVENT, function (ContextualMessage $context): void {
            $messageHandler = $context->messageHandlers()->current();

            if ($messageHandler) {
                $messageHandler($context->message()->event());
            }

            if (null !== $messageHandler || true === $context->message()->header(Header::ASYNC_MARKER->value)) {
                $context->markMessageHandled(true);
            }
        }, ReporterPriority::INVOKE_HANDLER->value);
    }
}
