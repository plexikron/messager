<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message;

interface Content
{
    public static function fromContent(array $content): Content;

    public function toContent(): array;
}
