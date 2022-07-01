<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message;

abstract class Domain implements Messaging
{
    use HasHeaders;

    final protected function __construct(protected array $content)
    {
    }

    public function toContent(): array
    {
        return $this->content;
    }

    public static function fromContent(array $content): static
    {
        return new static($content);
    }

    public function withHeader(string $header, mixed $value): Domain
    {
        $domain = clone $this;

        $domain->headers[$header] = $value;

        return $domain;
    }

    public function withHeaders(array $headers): Domain
    {
        $domain = clone $this;

        $domain->headers = $headers;

        return $domain;
    }
}
