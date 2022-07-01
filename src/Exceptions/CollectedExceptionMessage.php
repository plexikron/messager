<?php

declare(strict_types=1);

namespace Chronhub\Messager\Exceptions;

use Throwable;

class CollectedExceptionMessage extends ReportingMessageFailed
{
    private array $exceptions = [];

    public static function fromExceptions(Throwable ...$exceptions): self
    {
        $message = "One or many event handler(s) cause exception\n";

        foreach ($exceptions as $exception) {
            $message .= $exception->getMessage()."\n";
        }

        $self = new self($message);

        $self->exceptions = $exceptions;

        return $self;
    }

    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
