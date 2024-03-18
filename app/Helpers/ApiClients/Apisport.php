<?php

declare(strict_types=1);

namespace App\Helpers\ApiClients;

use App\Helpers\ApiClients\Exception\InvalidApisportTokenException;
use App\Helpers\ApiClients\Exception\MissingApisportTokenException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

final class Apisport implements ApiClientInterface
{
    public function __construct(private string $apiToken)
    {
        if ('' === $apiToken) {
            throw MissingApisportTokenException::create();
        }
    }

    public function get($uri): array
    {
        $response = Http::baseUrl('https://v3.football.api-sports.io/')
            ->withHeaders(['x-apisports-key' => $this->apiToken])
            ->get($uri)
            ->json();

        if (Arr::has($response, 'errors.token')) {
            throw InvalidApisportTokenException::create();
        }

        if ( ! isset($response)) {
            throw ExternalSystemUnavailableException::create();
        }

        return $response;
    }
}
