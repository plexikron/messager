<?php

declare(strict_types=1);

namespace Chronhub\Messager\Support\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static classToAlias(string $eventClass)
 * @method static instanceToAlias(object $instance)
 */
final class AliasMessage extends Facade
{
    public const SERVICE_NAME = 'messager.message.alias';

    protected static function getFacadeAccessor(): string
    {
        return self::SERVICE_NAME;
    }
}
