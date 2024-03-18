<?php

declare(strict_types=1);

namespace App\Helpers\ValueObject;

final class AutoGoal
{
    private const UN_MILIARDO_UNO = 1000000000;

    private const AUTO_GOL = 'AutoGol';

    public static function check(int $other): bool
    {
        $value = self::UN_MILIARDO_UNO + 1;

        return $value === $other;
    }

    public static function toString(): string
    {
        return self::AUTO_GOL;
    }
}
