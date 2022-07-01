<?php

declare(strict_types=1);

namespace Chronhub\Messager\Exceptions;

use Throwable;

class MessageDispatchFailed extends MessagingException
{
    public static function withException(Throwable $exception): self
    {
        $message = 'An error occurred while dispatching message. See previous exceptions';

        return new self($message, 422, $exception);
    }
}
