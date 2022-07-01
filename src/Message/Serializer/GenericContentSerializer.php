<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Serializer;

use Chronhub\Messager\Message\Header;
use Chronhub\Messager\Message\Content;
use Chronhub\Messager\Exceptions\RuntimeException;
use Chronhub\Messager\Support\Aggregate\AggregateChanged;

final class GenericContentSerializer
{
    public function serialize(Content $event): array
    {
        return $event->toContent();
    }

    public function unserialize(string $source, array $payload): Content
    {
        if (is_subclass_of($source, AggregateChanged::class)) {
            $aggregateId = $payload['headers'][Header::AGGREGATE_ID->value];

            return $source::occur($aggregateId, $payload['content']);
        }

        if (is_subclass_of($source, Content::class)) {
            return $source::fromContent($payload['content']);
        }

        throw new RuntimeException('Invalid source');
    }
}
