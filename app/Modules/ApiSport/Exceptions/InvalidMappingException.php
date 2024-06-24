<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Exceptions;

use RuntimeException;

final class InvalidMappingException extends RuntimeException
{
    public static function create(string $receivedMapping, string $expectedMapping): self
    {
        return new self(
            sprintf('Received mapping "%s" but expected "%s"', $receivedMapping, $expectedMapping)
        );
    }
}
