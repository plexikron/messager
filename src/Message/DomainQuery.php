<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message;

abstract class DomainQuery extends Domain
{
    public function type(): string
    {
        return DomainType::QUERY->name;
    }
}
