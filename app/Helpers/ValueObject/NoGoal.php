<?php

declare(strict_types=1);

namespace App\Helpers\ValueObject;

final class NoGoal
{
    public static function check(int $other): bool
    {
        return (10 ** 9) === $other;
    }

    public static function toString(): string
    {
        return 'NoGol';
    }
}
