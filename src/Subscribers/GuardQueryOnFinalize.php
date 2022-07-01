<?php

declare(strict_types=1);

namespace Chronhub\Messager\Subscribers;

use Chronhub\Messager\Reporter;
use React\Promise\PromiseInterface;
use Chronhub\Messager\Tracker\MessageTracker;
use Chronhub\Messager\Tracker\ContextualMessage;

final class GuardQueryOnFinalize extends GuardQuery
{
    public function attachToTracker(MessageTracker $tracker): void
    {
        $tracker->listen(Reporter::FINALIZE_EVENT, function (ContextualMessage $context): void {
            $promise = $context->promise();

            if ($promise instanceof PromiseInterface) {
                $promiseGuard = $promise->then(function ($result) use ($context) {
                    $this->authorizeQuery($context, $result);

                    return $result;
                });

                $context->withPromise($promiseGuard);
            }
        }, -1000);
    }
}
