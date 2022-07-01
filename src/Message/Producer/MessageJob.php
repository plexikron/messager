<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message\Producer;

use Chronhub\Messager\Message\Header;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;

final class MessageJob
{
    use InteractsWithQueue;

    public function __construct(public readonly array $payload,
                                public readonly string $reporterName,
                                public readonly ?string $connection,
                                public readonly ?string $queue)
    {
    }

    /**
     * @param  Container  $container
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function handle(Container $container): void
    {
        $container->make($this->reporterName)->publish($this->payload);
    }

    /**
     * @internal
     */
    public function queue(Queue $queue, MessageJob $messageJob): void
    {
        $queue->pushOn($this->queue, $messageJob);
    }

    public function displayName(): string
    {
        return $this->payload['headers'][Header::EVENT_TYPE->value];
    }
}
