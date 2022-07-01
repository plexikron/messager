<?php

declare(strict_types=1);

namespace Chronhub\Messager\Tests\Unit\Message;

use stdclass;
use Generator;
use Chronhub\Messager\Message\Domain;
use Chronhub\Messager\Message\Header;
use Chronhub\Messager\Message\Message;
use Chronhub\Messager\Tests\Double\SomeEvent;
use Chronhub\Messager\Tests\Double\SomeQuery;
use Chronhub\Messager\Tests\Double\SomeObject;
use Chronhub\Messager\Tests\Double\SomeCommand;
use Chronhub\Messager\Tests\TestCaseWithProphecy;
use Chronhub\Messager\Exceptions\RuntimeException;
use Chronhub\Messager\Exceptions\InvalidArgumentException;

class MessageTest extends TestCaseWithProphecy
{
    /**
     * @test
     * @dataProvider provideEventDomain
     *
     * @param  Domain  $domain
     * @return void
     */
    public function it_can_be_constructed_with_domain_message(Domain $domain): void
    {
        $message = new Message($domain);

        $this->assertEquals($message->event(), $domain);
        $this->assertCount(0, $message->headers());
        $this->assertFalse($message->has('some_header'));
        $this->assertTrue($message->hasNot('some_header'));
        $this->assertTrue($message->isMessaging());
    }

    /**
     * @test
     * @dataProvider provideEventObjects
     *
     * @param  object  $object
     * @return void
     */
    public function it_can_be_constructed_with_naked_object(object $object): void
    {
        $message = new Message($object);

        $this->assertEquals($message->event(), $object);
        $this->assertCount(0, $message->headers());
        $this->assertFalse($message->has('some_header'));
        $this->assertTrue($message->hasNot('some_header'));
        $this->assertFalse($message->isMessaging());
    }

    /**
     * @test
     */
    public function it_can_be_constructed_with_headers(): void
    {
        $message = new Message(new stdclass(), [Header::EVENT_ID->name => '123']);

        $this->assertTrue($message->has(Header::EVENT_ID->name));
        $this->assertEquals('123', $message->header(Header::EVENT_ID->name));
    }

    /**
     * @test
     */
    public function it_raise_exception_if_message_event_is_an_instance_of_message(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Message event can not be an instance of '.Message::class);

        new Message(new Message(new stdclass()));
    }

    /**
     * @test
     */
    public function it_can_override_header(): void
    {
        $message = new Message(new stdclass(), [Header::EVENT_ID->name => '123']);

        $messageWithHeaders = $message->withHeader(Header::EVENT_ID->name, '456');

        $this->assertNotEquals($message, $messageWithHeaders);

        $this->assertEquals([Header::EVENT_ID->name => '123'], $message->headers());
        $this->assertEquals([Header::EVENT_ID->name => '456'], $messageWithHeaders->headers());
    }

    /**
     * @test
     */
    public function it_can_override_headers(): void
    {
        $message = new Message(new stdclass(), [Header::EVENT_ID->name => '123']);

        $messageWithHeaders = $message->withHeaders([Header::EVENT_ID->name => '456']);

        $this->assertNotEquals($message, $messageWithHeaders);

        $this->assertEquals([Header::EVENT_ID->name => '123'], $message->headers());
        $this->assertEquals([Header::EVENT_ID->name => '456'], $messageWithHeaders->headers());
    }

    /**
     * @test
     * @dataProvider provideHeaders
     */
    public function it_return_event_messaging_with_headers(array $headers): void
    {
        $event = SomeCommand::fromContent(['name' => 'steph']);

        $message = new Message(SomeCommand::fromContent(['name' => 'steph']), $headers);

        $this->assertEquals($event->withHeaders($headers), $message->event());
    }

    /**
     * @test
     */
    public function it_return_event_messaging_without_headers(): void
    {
        $event = SomeCommand::fromContent(['name' => 'steph']);
        $headers = ['some' => 'header'];

        $message = new Message(SomeCommand::fromContent(['name' => 'steph']), $headers);

        $this->assertEquals($event, $message->eventWithoutHeaders());
    }

    /**
     * @test
     */
    public function it_return_event_headers_when_message_headers_is_empty_on_construct(): void
    {
        $event = SomeCommand::fromContent(['name' => 'steph']);
        $event = $event->withHeaders(['some' => 'header']);

        $message = new Message($event, []);

        $this->assertEquals(['some' => 'header'], $message->headers());
        $this->assertEquals(['some' => 'header'], $message->event()->headers());
    }

    /**
     * @test
     */
    public function it_return_event_headers_when_message_headers_equals_event_headers_on_construct(): void
    {
        $event = SomeCommand::fromContent(['name' => 'steph']);
        $event = $event->withHeaders(['some' => 'header']);

        $message = new Message($event, ['some' => 'header']);

        $this->assertEquals(['some' => 'header'], $message->headers());
        $this->assertEquals(['some' => 'header'], $message->event()->headers());
    }

    /**
     * @test
     */
    public function it_raise_exception_when_message_headers_does_not_match_event_messaging_headers(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid headers consistency for event class '.SomeCommand::class);

        $event = SomeCommand::fromContent(['name' => 'steph']);
        $event = $event->withHeaders(['some' => 'header']);

        new Message($event, ['another' => 'header']);
    }

    /**
     * @test
     */
    public function it_return_event_not_messaging_without_headers(): void
    {
        $message = new Message(new stdclass());

        $this->assertEquals(new stdclass(), $message->eventWithoutHeaders());
    }

    public function provideEventDomain(): Generator
    {
        yield [SomeCommand::fromContent(['name' => 'steph bug'])];
        yield [SomeEvent::fromContent(['name' => 'steph bug'])];
        yield [SomeQuery::fromContent(['name' => 'steph bug'])];
    }

    public function provideEventObjects(): Generator
    {
        yield [new stdclass()];
        yield [new SomeObject()];
    }

    public function provideHeaders(): Generator
    {
        yield [[]];
        yield [['some' => 'header']];
    }
}
