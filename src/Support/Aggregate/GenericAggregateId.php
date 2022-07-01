<?php

declare(strict_types=1);

namespace Chronhub\Messager\Support\Aggregate;

final class GenericAggregateId implements AggregateId
{
    use HasAggregateIdentity;
}
