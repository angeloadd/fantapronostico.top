<?php

declare(strict_types=1);

namespace App\Helpers\ApiClients;

use App\Models\Team;

final readonly class ParseFromFile implements ApiClientInterface
{
    public function __construct(
        private string $path
    ) {
    }

    public function get(string $uri): array
    {
        $fileName = $this->parseUri($uri);

        $str = $this->path . '/' . $fileName . '.json';

        return json_decode(file_get_contents($str), true, 512, JSON_THROW_ON_ERROR);
    }

    private function parseUri(string $uri): string
    {
        if (str_contains($uri, 'teams')) {
            return 'teams';
        }

        if (str_contains($uri, 'fixtures')) {
            if ( ! str_contains($uri, 'id')) {
                return 'games';
            }

            return 'fixtureRound';
        }

        if (str_contains($uri, 'squads')) {
            $page = explode('team=', $uri)[1];

            return 'players' . Team::find($page)->name;
        }

        if (str_contains($uri, 'events')) {
            return 'fixtureEventsRound';
        }

        if (str_contains($uri, 'topscorers')) {
            return 'topscorers';
        }

        return 'players';
    }
}
