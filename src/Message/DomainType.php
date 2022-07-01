<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message;

enum DomainType
{
    case COMMAND;
    case QUERY;
    case EVENT;
}
