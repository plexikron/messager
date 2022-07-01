<?php

declare(strict_types=1);

namespace Chronhub\Messager\Subscribers;

use Chronhub\Messager\Reporter;
use React\Promise\PromiseInterface;
use Chronhub\Messager\ReporterPriority;
use Chronhub\Messager\Tracker\MessageTracker;
use Chronhub\Messager\Tracker\ContextualMessage;

final class GuardQueryOnDispatch extends GuardQuery
{
    public function attachToTracker(MessageTracker $tracker): void
    {
        $tracker->listen(Reporter::DISPATCH_EVENT, function (ContextualMessage $context): void {
            $promise = $context->promise();

            if ($promise instanceof PromiseInterface) {
                $this->authorizeQuery($context);
            }
        }, ReporterPriority::INVOKE_HANDLER->value - 1);
    }
}
