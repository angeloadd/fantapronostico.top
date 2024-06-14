<?php

declare(strict_types=1);

namespace App\Helpers\Mappers\Apisport;

use App\Models\Game;

final class GameEventsMapper
{
    private const OWN_GOAL = 1000000000;

    public function __construct(private readonly array $gameEvents)
    {
    }

    public static function fromArray(array $response, Game $game): self
    {
        $homeScorers = self::getList($response, $game->home_team->api_id);
        $awayScorers = self::getList($response, $game->away_team->api_id);
        $homeResult = count($homeScorers);
        $awayResult = count($awayScorers);

        return new self([
            'home_score' => $homeResult,
            'away_score' => $awayResult,
            'sign' => self::getGameSign($homeResult, $awayResult),
            'home_scorers' => $homeScorers,
            'away_scorers' => $awayScorers,
            'status' => 'completed',
        ]);
    }

    public function toArray(): array
    {
        return $this->gameEvents;
    }

    private static function getList(array $response, int $teamId): array
    {
        $scorerList = [];
        foreach ($response as $event) {
            if ($event['team']['id'] === $teamId) {
                // If a goal is a penalty in the shootouts skip
                if (120 === $event['time']['elapsed'] && null !== $event['time']['extra'] && str_contains($event['comments'], 'Penalty')) {
                    continue;
                }
                // if a player missed a penalty we don't care
                if (str_contains($event['detail'], 'Missed')) {
                    continue;
                }
                $scorerList[] = [
                    'id' => $event['player']['id'],
                    'is_autogoal' => str_contains($event['detail'], 'Own'),
                    'scored_at' => $event['time']['elapsed'] + ($event['time']['extra'] ?? 0),
                ];
            }
        }

        return $scorerList;
    }

    private static function getGameSign(?int $home, ?int $away): ?string
    {
        if (null === $home && null === $away) {
            return null;
        }

        if ($home > $away) {
            return '1';
        }

        if ($home < $away) {
            return '2';
        }

        return 'x';
    }
}
