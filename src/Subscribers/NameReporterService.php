<?php

declare(strict_types=1);

namespace Chronhub\Messager\Subscribers;

use Chronhub\Messager\Reporter;
use Chronhub\Messager\Message\Header;
use Chronhub\Messager\ReporterPriority;
use Chronhub\Messager\Tracker\MessageTracker;
use Chronhub\Messager\Tracker\ContextualMessage;

final class NameReporterService implements MessageSubscriber
{
    public function __construct(private string $reporterServiceName)
    {
    }

    public function attachToTracker(MessageTracker $tracker): void
    {
        $tracker->listen(Reporter::DISPATCH_EVENT, function (ContextualMessage $context): void {
            $message = $context->message();

            if ($message->hasNot(Header::REPORTER_NAME->value)) {
                $context->withMessage(
                    $message->withHeader(Header::REPORTER_NAME->value, $this->reporterServiceName)
                );
            }
        }, ReporterPriority::MESSAGE_FACTORY->value - 1);
    }
}
