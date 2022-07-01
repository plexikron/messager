<?php

declare(strict_types=1);

namespace Chronhub\Messager\Exceptions;

final class MessageNotHandled extends ReportingMessageFailed
{
    public static function withMessageName(string $message): self
    {
        return new self("Message $message not handled");
    }
}
