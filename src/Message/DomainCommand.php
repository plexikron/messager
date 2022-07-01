<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message;

abstract class DomainCommand extends Domain
{
    public function type(): string
    {
        return DomainType::COMMAND->name;
    }
}
