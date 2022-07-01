<?php

declare(strict_types=1);

namespace Chronhub\Messager\Support\Aggregate;

interface AggregateId
{
    public static function fromString(string $aggregateId): AggregateId;

    public function toString(): string;

    public function equalsTo(AggregateId $aggregateId): bool;
}
