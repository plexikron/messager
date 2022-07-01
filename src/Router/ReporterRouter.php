<?php

declare(strict_types=1);

namespace Chronhub\Messager\Router;

use Closure;
use Illuminate\Support\Collection;
use Chronhub\Messager\Message\Message;
use Illuminate\Contracts\Container\Container;
use Chronhub\Messager\Message\Alias\MessageAlias;
use Chronhub\Messager\Exceptions\ReportingMessageFailed;
use Illuminate\Contracts\Container\BindingResolutionException;
use function is_string;
use function is_callable;

final class ReporterRouter implements Router
{
    public function __construct(private array $map,
                                private MessageAlias $messageAlias,
                                private ?Container $container,
                                private ?string $callableMethod)
    {
    }

    public function route(Message $message): iterable
    {
        return $this
            ->determineMessageHandler($message)
            ->transform(
                fn ($messageHandler): callable => $this->messageHandlerToCallable($messageHandler)
            );
    }

    private function messageHandlerToCallable(callable|object|string $messageHandler): callable
    {
        if (is_string($messageHandler)) {
            $messageHandler = $this->locateStringMessageHandler($messageHandler);
        }

        if (is_callable($messageHandler)) {
            return $messageHandler;
        }

        if ($this->callableMethod && method_exists($messageHandler, $this->callableMethod)) {
            return Closure::fromCallable([$messageHandler, $this->callableMethod]);
        }

        throw ReportingMessageFailed::messageHandlerNotSupported();
    }

    private function determineMessageHandler(Message $message): Collection
    {
        $messageAlias = $this->messageAlias->instanceToAlias($message->event());

        if (null === $messageHandlers = $this->map[$messageAlias] ?? null) {
            throw ReportingMessageFailed::messageNameNotFound($messageAlias);
        }

        return (new Collection())->wrap($messageHandlers);
    }

    /**
     * @throws BindingResolutionException
     */
    private function locateStringMessageHandler(string $messageHandler): object
    {
        if (! $this->container) {
            throw ReportingMessageFailed::missingContainer($messageHandler);
        }

        return $this->container->make($messageHandler);
    }
}
