<?php

declare(strict_types=1);

namespace Chronhub\Messager\Exceptions;

class ReportingMessageFailed extends MessagingException
{
    public static function messageHandlerNotSupported(): self
    {
        return new self('Message handler type not supported');
    }

    public static function oneMessageHandlerOnly(): self
    {
        return new self('Router require one message handler only');
    }

    public static function messageNameNotFound(string $messageName): self
    {
        return new self("Message name $messageName not found in map");
    }

    public static function missingContainer(string $messageHandler): self
    {
        return new self("Container is required for string message handler $messageHandler");
    }

    public static function missingAsyncMarkerHeader(string $eventType): self
    {
        return new self("Missing async marker for event $eventType");
    }
}
