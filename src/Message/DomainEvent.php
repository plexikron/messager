<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message;

abstract class DomainEvent extends Domain
{
    public function type(): string
    {
        return DomainType::EVENT->name;
    }
}
