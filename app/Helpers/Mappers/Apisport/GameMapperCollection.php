<?php

declare(strict_types=1);

namespace App\Helpers\Mappers\Apisport;

final class GameMapperCollection
{
    public function __construct(private array $teamMappers)
    {
    }

    public static function fromArray(array $response): self
    {
        return new self(
            array_map(
                static function (array $item): array {
                    return [
                        'id' => $item['fixture']['id'],
                        'home_team' => $item['teams']['home']['id'],
                        'away_team' => $item['teams']['away']['id'],
                        'started_at' => $item['fixture']['timestamp'],
                        'stage' => self::getGameType($item['league']['round']),
                        'tournament_id' => 4,
                    ];
                },
                $response
            )
        );
    }

    public function toArray(): array
    {
        return $this->teamMappers;
    }

    private static function getGameType(string $round): string
    {
        if (str_contains($round, 'Group')) {
            return 'group';
        }

        if ('Final' === $round) {
            return 'final';
        }

        return 'round';
    }
}
