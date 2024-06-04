<?php

declare(strict_types=1);

namespace App\Enums;

use InvalidArgumentException;
use UnitEnum;

trait HasValues
{
    public function values(): array
    {
        if ( ! $this instanceof UnitEnum) {
            throw new InvalidArgumentException('This trait can be only used by enum classes');
        }

        return array_map(
            static fn (self $enumCase) => $enumCase->value,
            $this::cases()
        );
    }
}
