<?php

declare(strict_types=1);

namespace Chronhub\Messager;

use Throwable;
use Chronhub\Messager\Message\Header;
use Chronhub\Messager\Tracker\TrackMessage;
use Chronhub\Messager\Tracker\MessageTracker;
use Chronhub\Messager\Tracker\ContextualMessage;
use Chronhub\Messager\Exceptions\MessageNotHandled;
use Chronhub\Messager\Subscribers\MessageSubscriber;
use Chronhub\Messager\Exceptions\MessageDispatchFailed;
use function get_called_class;

trait HasReporter
{
    public function __construct(protected ?string $name = null,
                                protected ?MessageTracker $tracker = new TrackMessage())
    {
    }

    protected function publishMessage(ContextualMessage $context): void
    {
        try {
            $this->tracker->fire($context);

            if (! $context->isMessageHandled()) {
                $messageName = $context->message()->header(Header::EVENT_TYPE->value);

                throw MessageNotHandled::withMessageName($messageName);
            }
        } catch (Throwable $exception) {
            $wrapException = MessageDispatchFailed::withException($exception);

            $context->withRaisedException($wrapException);
        } finally {
            $context->stopPropagation(false);

            $context->withEvent(self::FINALIZE_EVENT);

            $this->tracker->fire($context);

            if ($context->hasException()) {
                throw $context->exception();
            }
        }
    }

    public function subscribe(MessageSubscriber ...$subscribers): void
    {
        foreach ($subscribers as $subscriber) {
            $subscriber->attachToTracker($this->tracker);
        }
    }

    public function name(): string
    {
        return $this->name ?? get_called_class();
    }
}
