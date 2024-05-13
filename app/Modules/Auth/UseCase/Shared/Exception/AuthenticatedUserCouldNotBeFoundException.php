<?php

declare(strict_types=1);

namespace App\Modules\Auth\UseCase\Shared\Exception;

use RuntimeException;

final class AuthenticatedUserCouldNotBeFoundException extends RuntimeException
{
    public static function create(): self
    {
        return new self('Authenticated user could not be found after login attempt was successful', 500);
    }
}
