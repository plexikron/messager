<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message;

interface Messaging extends Content
{
    public function withHeaders(array $headers): Domain;

    public function withHeader(string $header, mixed $value): Domain;

    public function has(string $key): bool;

    public function hasNot(string $key): bool;

    public function header(string $key): mixed;

    public function headers(): array;

    public function type(): string;
}
