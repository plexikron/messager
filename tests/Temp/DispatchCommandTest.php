<?php

declare(strict_types=1);

namespace Chronhub\Messager\Tests\Temp;

use Throwable;
use Ramsey\Uuid\Uuid;
use DateTimeImmutable;
use Chronhub\Messager\ReportCommand;
use Chronhub\Messager\Message\Header;
use Chronhub\Messager\Router\ReporterRouter;
use Chronhub\Messager\Subscribers\MakeMessage;
use Chronhub\Messager\Subscribers\HandleRouter;
use Chronhub\Messager\Tests\Double\SomeCommand;
use Chronhub\Messager\Subscribers\HandleCommand;
use Chronhub\Messager\Router\SingleHandlerRouter;
use Chronhub\Messager\Tests\TestCaseWithProphecy;
use Chronhub\Messager\Subscribers\NameReporterService;
use Chronhub\Messager\Message\Alias\AliasFromInflector;
use Chronhub\Messager\Support\Clock\UniversalPointInTime;
use Chronhub\Messager\Support\Clock\UniversalSystemClock;
use Chronhub\Messager\Message\Producer\SyncMessageProducer;
use Chronhub\Messager\Message\Factory\GenericMessageFactory;
use Chronhub\Messager\Message\Decorator\DefaultMessageDecorators;
use Chronhub\Messager\Message\Serializer\GenericMessageSerializer;
use Chronhub\Messager\Subscribers\ChainMessageDecoratorSubscriber;

final class DispatchCommandTest extends TestCaseWithProphecy
{
    /**
     * @test
     *
     * @return void
     *
     * @throws Throwable
     */
    public function it_dispatch_command(): void
    {
        $messageHandled = false;
        $someCommand = null;

        $map = [
            'some-command' => function (SomeCommand $command) use (&$messageHandled, &$someCommand): void {
                $someCommand = $command;
                $messageHandled = true;
            },
        ];

        $reporter = new ReportCommand('report.command');

        $reporter->subscribe(
            new NameReporterService($reporter->name()),
            new MakeMessage(new GenericMessageFactory(new GenericMessageSerializer(new UniversalSystemClock()))),
            new ChainMessageDecoratorSubscriber(new DefaultMessageDecorators()),
            new HandleRouter(
               new SingleHandlerRouter(
                   new ReporterRouter($map, new AliasFromInflector(), null, null)
               ),
               new SyncMessageProducer()
            ),
           new HandleCommand(),
        );

        $event = SomeCommand::fromContent(['steph' => 'bug']);

        $reporter->publish($event);

        $this->assertTrue($messageHandled);

        $this->assertEquals('report.command', $reporter->name());
        $this->assertEquals('report.command', $someCommand->header(Header::REPORTER_NAME->value));

        $this->assertEquals(['steph' => 'bug'], $someCommand->toContent());
        $this->assertTrue(Uuid::isValid($someCommand->header(Header::EVENT_ID->value)));
        $this->assertFalse($someCommand->header(Header::ASYNC_MARKER->value));
        $this->assertEquals(SomeCommand::class, $someCommand->header(Header::EVENT_TYPE->value));
        $this->assertInstanceOf(
            DateTimeImmutable::class,
            UniversalPointInTime::fromString($someCommand->header(Header::EVENT_TIME->value))->dateTime()
        );

        dump($someCommand);
    }
}
