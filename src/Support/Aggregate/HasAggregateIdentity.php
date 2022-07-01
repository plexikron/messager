<?php

declare(strict_types=1);

namespace Chronhub\Messager\Support\Aggregate;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use function get_class;

trait HasAggregateIdentity
{
    private UuidInterface $identifier;

    protected function __construct(UuidInterface $identifier)
    {
        $this->identifier = $identifier;
    }

    public static function fromString(string $aggregateId): self
    {
        return new self(Uuid::fromString($aggregateId));
    }

    public function toString(): string
    {
        return $this->identifier->toString();
    }

    public function equalsTo(AggregateId $rootId): bool
    {
        return static::class === get_class($rootId)
            && $this->toString() === $rootId->toString();
    }

    public static function create(): self
    {
        return new self(Uuid::uuid4());
    }
}
