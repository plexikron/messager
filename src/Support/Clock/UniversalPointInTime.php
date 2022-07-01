<?php

declare(strict_types=1);

namespace Chronhub\Messager\Support\Clock;

use DateInterval;
use DateTimeZone;
use DateTimeImmutable;
use Chronhub\Messager\Exceptions\InvalidArgumentException;

final class UniversalPointInTime implements PointInTime
{
    const DATE_TIME_FORMAT = 'Y-m-d\TH:i:s.u';

    public static function fromDateTime(DateTimeImmutable $pointInTime): self
    {
        $pointInTime = $pointInTime->setTimezone(new DateTimeZone('UTC'));

        return new self($pointInTime);
    }

    public static function fromString(string $pointInTime): self
    {
        $timeZone = new DateTimeZone('UTC');

        $pointInTime = DateTimeImmutable::createFromFormat(self::DATE_TIME_FORMAT, $pointInTime, $timeZone);

        if (! $pointInTime) {
            throw new InvalidArgumentException('Invalid date time');
        }

        return new self($pointInTime);
    }

    public static function now(): self
    {
        $dateTime = new DateTimeImmutable('now', new DateTimeZone('UTC'));

        return new self($dateTime);
    }

    public function equals(PointInTime $pointInTime): bool
    {
        return $this->toString() === $pointInTime->toString();
    }

    public function after(PointInTime $pointInTime): bool
    {
        return $this->dateTime > $pointInTime->dateTime();
    }

    public function diff(PointInTime $pointInTime): DateInterval
    {
        return $this->dateTime->diff($pointInTime->dateTime());
    }

    public function add(string $interval): self
    {
        $datetime = $this->dateTime->add(new DateInterval($interval));

        return new self($datetime);
    }

    public function sub(string $interval): self
    {
        $datetime = $this->dateTime->sub(new DateInterval($interval));

        return new self($datetime);
    }

    public function dateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->dateTime->format(self::DATE_TIME_FORMAT);
    }

    private function __construct(private DateTimeImmutable $dateTime)
    {
    }
}
