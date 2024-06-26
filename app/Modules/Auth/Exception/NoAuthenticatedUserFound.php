<?php

declare(strict_types=1);

namespace App\Modules\Auth\Exception;

use RuntimeException;

final class NoAuthenticatedUserFound extends RuntimeException
{
    public static function create(): self
    {
        return new self('No authenticated user found', 401);
    }
}
