<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Client;

use App\Modules\ApiSport\Exceptions\ExternalSystemUnavailableException;
use App\Modules\ApiSport\Exceptions\InvalidApisportTokenException;
use Illuminate\Http\Client\ConnectionException;

interface ApiSportClientInterface
{
    /**
     * @throws ExternalSystemUnavailableException
     * @throws InvalidApisportTokenException
     * @throws ConnectionException
     */
    public function get(string $endpoint, array $query = []): array;
}
