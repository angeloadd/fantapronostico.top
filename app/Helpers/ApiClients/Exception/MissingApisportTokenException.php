<?php

declare(strict_types=1);

namespace App\Helpers\ApiClients\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

final class MissingApisportTokenException extends Exception
{
    public static function create(): self
    {
        return new self(
            'missing apisport token in env',
            Response::HTTP_BAD_REQUEST
        );
    }
}
