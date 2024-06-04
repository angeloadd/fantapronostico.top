<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

final class InvalidApisportTokenException extends Exception
{
    public static function create(): self
    {
        return new self(
            'Invalid apisport token',
            Response::HTTP_BAD_REQUEST
        );
    }
}
