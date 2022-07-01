<?php

declare(strict_types=1);

namespace Chronhub\Messager\Subscribers;

use Chronhub\Messager\Message\Header;
use Chronhub\Messager\AuthorizeMessage;
use Chronhub\Messager\Tracker\ContextualMessage;
use Chronhub\Messager\Message\Alias\MessageAlias;
use Chronhub\Messager\Exceptions\UnauthorizedException;

abstract class GuardQuery implements MessageSubscriber
{
    public function __construct(private AuthorizeMessage $authorizationService,
                                private MessageAlias $messageAlias)
    {
    }

    protected function authorizeQuery(ContextualMessage $context, mixed $result = null): void
    {
        $message = $context->message();

        $eventAlias = $this->messageAlias->classToAlias($message->header(Header::EVENT_TYPE->value));

        if ($this->authorizationService->isNotGranted($eventAlias, $message, $result)) {
            $context->stopPropagation(true);

            throw new UnauthorizedException("Unauthorized for event $eventAlias");
        }
    }
}
