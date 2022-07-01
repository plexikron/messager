<?php

declare(strict_types=1);

namespace Chronhub\Messager;

use Chronhub\Messager\Message\Message;
use Chronhub\Messager\Exceptions\UnauthorizedException;

interface AuthorizeMessage
{
    /**
     * @param  string  $event
     * @param  Message  $message
     * @param  mixed|null  $context
     * @return bool
     *
     * @throws UnauthorizedException
     */
    public function isGranted(string $event, Message $message, mixed $context = null): bool;

    /**
     * @param  string  $event
     * @param  Message  $message
     * @param  mixed|null  $context
     * @return bool
     *
     * @throws UnauthorizedException
     */
    public function isNotGranted(string $event, Message $message, mixed $context = null): bool;
}
