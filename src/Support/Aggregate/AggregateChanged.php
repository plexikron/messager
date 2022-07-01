<?php

declare(strict_types=1);

namespace Chronhub\Messager\Support\Aggregate;

use Chronhub\Messager\Message\DomainEvent;

abstract class AggregateChanged extends DomainEvent
{
    private ?string $aggregateId;

    public static function occur(string $aggregateId, array $content): static
    {
        $event = new static($content);

        $event->aggregateId = $aggregateId;

        return $event;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }
}
