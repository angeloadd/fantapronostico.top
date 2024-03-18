<?php

declare(strict_types=1);

namespace App\Helpers\ApiClients;

use Exception;

final class ExternalSystemUnavailableException extends Exception
{
    public static function create(): self
    {
        return new self('External system unavailable', 424);
    }
}
