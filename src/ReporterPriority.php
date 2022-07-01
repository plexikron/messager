<?php

declare(strict_types=1);

namespace Chronhub\Messager;

enum ReporterPriority : int
{
    case MESSAGE_FACTORY = 100000;
    case MESSAGE_DECORATOR = 90000;
    case MESSAGE_VALIDATION = 30000;
    case ROUTE = 20000;
    case INVOKE_HANDLER = 0;
}
