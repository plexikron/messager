<?php

declare(strict_types=1);

namespace Chronhub\Messager\Support\Aggregate;

use Generator;
use Chronhub\Messager\Message\DomainEvent;

interface AggregateRoot
{
    /**
     * @param  AggregateId  $aggregateId
     * @param  Generator<DomainEvent>  $events
     * @return self|null
     */
    public static function reconstituteFromEvents(AggregateId $aggregateId, Generator $events): ?AggregateRoot;

    /**
     * @return DomainEvent[]
     */
    public function releaseEvents(): array;

    public function aggregateId(): AggregateId;

    public function version(): int;
}
