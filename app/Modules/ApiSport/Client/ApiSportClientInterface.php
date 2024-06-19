<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Client;

use App\Modules\ApiSport\Exceptions\ExternalSystemUnavailableException;
use App\Modules\ApiSport\Exceptions\InvalidApisportTokenException;
use Illuminate\Http\Client\ConnectionException;

interface ApiSportClientInterface
{
    /**
     * @param  array<string, string|int>  $query
     * @return array<string, array<string, int|string>>
     *
     * @throws ExternalSystemUnavailableException
     * @throws InvalidApisportTokenException
     * @throws ConnectionException
     */
    public function get(string $endpoint, array $query = []): array;
}
