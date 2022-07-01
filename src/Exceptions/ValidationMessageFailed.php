<?php

declare(strict_types=1);

namespace Chronhub\Messager\Exceptions;

use Chronhub\Messager\Message\Message;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator;

class ValidationMessageFailed extends ReportingMessageFailed
{
    private static ?Validator $validator;

    private static ?Message $validatedMessage;

    public static function withValidator(Validator $validator, Message $message): self
    {
        self::$validator = $validator;
        self::$validatedMessage = $message;

        $exceptionMessage = "Validation rules fails:\n";
        $exceptionMessage .= $validator->errors();

        return new self($exceptionMessage);
    }

    public function getValidator(): Validator
    {
        return ValidationMessageFailed::$validator;
    }

    public function failedMessage(): Message
    {
        return ValidationMessageFailed::$validatedMessage;
    }

    public function errors(): MessageBag
    {
        return $this->getValidator()->errors();
    }
}
