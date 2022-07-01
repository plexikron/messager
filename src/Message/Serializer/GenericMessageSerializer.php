<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Serializer;

use Generator;
use Ramsey\Uuid\Uuid;
use JetBrains\PhpStorm\ArrayShape;
use Chronhub\Messager\Message\Header;
use Chronhub\Messager\Message\Content;
use Chronhub\Messager\Message\Message;
use Chronhub\Messager\Support\Clock\Clock;
use Chronhub\Messager\Exceptions\RuntimeException;
use Chronhub\Messager\Support\Aggregate\AggregateChanged;
use function is_string;

final class GenericMessageSerializer implements MessageSerializer
{
    public function __construct(private Clock $clock,
                                private ?GenericContentSerializer $contentSerializer = new GenericContentSerializer())
    {
    }

    #[ArrayShape(['headers' => 'array', 'content' => 'array'])]
    public function serializeMessage(Message $message): array
    {
        $event = $message->event();
        $headers = $message->headers();

        if (! $event instanceof Content) {
            throw new RuntimeException('Message event must be an instance of Content to be serialized');
        }

        $headers = $this->normalizeEventId($headers);
        $headers = $this->normalizeEventTime($headers);

        if ($message->hasNot(Header::EVENT_TYPE->name)) {
            $headers[Header::EVENT_TYPE->value] = $event::class;
        }

        if (is_subclass_of($event, AggregateChanged::class)) {
            $headers = $this->checkAggregateIdAndType($headers);
        }

        return [
            'headers' => $headers,
            'content' => $this->contentSerializer->serialize($event),
        ];
    }

    public function unserializeContent(array $payload): Generator
    {
        $headers = $payload['headers'];

        $source = $headers[Header::EVENT_TYPE->value] ?? null;

        if (null === $source) {
            throw new RuntimeException('Missing event type header from payload');
        }

        $event = $this->contentSerializer->unserialize($source, $payload);

        $headers = $this->normalizeEventId($headers);
        $headers = $this->normalizeEventTime($headers);

        if (is_subclass_of($source, AggregateChanged::class)) {
            if (! isset($headers[Header::INTERNAL_POSITION->value])) {
                $headers[Header::INTERNAL_POSITION->value] = $payload['no'];
            }

            $headers = $this->checkAggregateIdAndType($headers);
        }

        yield $event->withHeaders($headers);
    }

    private function normalizeEventId(array $headers): array
    {
        $eventId ??= $headers[Header::EVENT_ID->value];

        if (null === $eventId) {
            return $headers + [Header::EVENT_ID->value => Uuid::uuid4()->toString()];
        }

        if (! is_string($eventId)) {
            $headers[Header::EVENT_ID->value] = (string) $headers[Header::EVENT_ID->value];
        }

        return $headers;
    }

    private function normalizeEventTime(array $headers): array
    {
        $eventTime ??= $headers[Header::EVENT_TIME->value];

        if (null === $eventTime) {
            return $headers + [Header::EVENT_TIME->value => $this->clock->fromNow()->toString()];
        }

        if (! is_string($eventTime)) {
            $headers[Header::EVENT_TIME->value] = (string) $headers[Header::EVENT_TIME->value];
        }

        return $headers;
    }

    private function checkAggregateIdAndType(array $headers): array
    {
        if (! isset($headers[Header::AGGREGATE_ID->value], $headers[Header::AGGREGATE_ID_TYPE->value])) {
            throw new RuntimeException('Missing aggregate id and type');
        }

        return $headers;
    }
}
