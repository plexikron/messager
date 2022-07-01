<?php

declare(strict_types=1);

namespace Chronhub\Messager\Support\Clock;

use DateInterval;
use DateTimeImmutable;

interface PointInTime
{
    public static function fromString(string $pointInTime): self;

    public static function fromDateTime(DateTimeImmutable $pointInTime): self;

    public static function now(): self;

    public function equals(PointInTime $pointInTime): bool;

    public function after(PointInTime $pointInTime): bool;

    public function add(string $interval): self;

    public function sub(string $interval): self;

    public function diff(PointInTime $pointInTime): DateInterval;

    public function dateTime(): DateTimeImmutable;

    public function __toString(): string;

    public function toString(): string;
}
