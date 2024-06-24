<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Exceptions;

use RuntimeException;

final class NoMapperStrategyFoundException extends RuntimeException
{
    public static function create(string $supportedEndpoint): self
    {
        return new self(
            sprintf('No mapper strategy found for response: %s', $supportedEndpoint)
        );
    }
}
