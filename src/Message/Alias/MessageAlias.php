<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Alias;

interface MessageAlias
{
    public function classToAlias(string $eventClass): string;

    public function instanceToAlias(object $event): string;
}
