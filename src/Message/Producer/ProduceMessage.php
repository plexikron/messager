<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Producer;

use Chronhub\Messager\Message\Header;
use Chronhub\Messager\Message\Content;
use Chronhub\Messager\Message\Message;
use Chronhub\Messager\Exceptions\RuntimeException;

abstract class ProduceMessage implements MessageProducer
{
    public function __construct(protected MessageQueue $queueProducer)
    {
    }

    public function produce(Message $message): Message
    {
        if ($this->isSync($message)) {
            return $message;
        }

        return $this->produceMessageAsync($message);
    }

    public function isSync(Message $message): bool
    {
        if (! $message->event() instanceof Content) {
            return true;
        }

        if (null === $message->header(Header::ASYNC_MARKER->value)) {
            throw new RuntimeException('Async marker header is required to produce message sync/async for event'.$message->event()::class);
        }

        if ($this->isAlreadyProducedAsync($message)) {
            return true;
        }

        return $this->isSyncWithStrategy($message);
    }

    protected function isAlreadyProducedAsync(Message $message): bool
    {
        return true === $message->header(Header::ASYNC_MARKER->value);
    }

    private function produceMessageAsync(Message $message): Message
    {
        $message = $message->withHeader(Header::ASYNC_MARKER->value, true);

        $this->queueProducer->toQueue($message);

        return $message;
    }

    abstract protected function isSyncWithStrategy(Message $message): bool;
}
