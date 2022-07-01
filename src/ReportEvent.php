<?php

declare(strict_types=1);

namespace Chronhub\Messager;

final class ReportEvent implements Reporter
{
    use HasReporter;

    public function publish(object|array $event): void
    {
        $context = $this->tracker->newContext(Reporter::DISPATCH_EVENT);

        $context->withTransientMessage($event);

        $this->publishMessage($context);
    }
}
