<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Alias;

use Chronhub\Messager\Exceptions\InvalidArgumentException;

final class AliasFromClassname implements MessageAlias
{
    public function classToAlias(string $eventClass): string
    {
        if (! class_exists($eventClass)) {
            throw new InvalidArgumentException("Event class $eventClass does not exists");
        }

        return $eventClass;
    }

    public function instanceToAlias(object $event): string
    {
        return $event::class;
    }
}
