<?php

declare(strict_types=1);

namespace App\Helpers\Mappers\Apisport;

use App\Models\Game;

final class GameEventsMapper
{
    private const OWN_GOAL = 1000000000;

    public function __construct(private array $gameEvents)
    {
    }

    public static function fromArray(array $response, Game $game): self
    {
        $homeScorers = self::getList($response, $game->home->id);
        $awayScorers = self::getList($response, $game->away->id);
        $homeResult = self::inferResult($homeScorers);
        $awayResult = self::inferResult($awayScorers);

        return new self([
            'home_result' => $homeResult,
            'away_result' => $awayResult,
            'sign' => self::getGameSign($homeResult, $awayResult),
            'home_score' => $homeScorers,
            'away_score' => $awayScorers,
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
                if (str_contains($event['detail'], 'Own')) {
                    $scorerList[] = 1000000001;
                } else {
                    if (120 === $event['time']['elapsed'] && null !== $event['time']['extra'] && str_contains($event['detail'], 'Penalty')) {
                        continue;
                    }
                    if (str_contains($event['detail'], 'Missed')) {
                        continue;
                    }
                    $scorerList[] = $event['player']['id'];
                }
            }
        }

        return count($scorerList) > 0 ? $scorerList : [self::OWN_GOAL];
    }

    private static function inferResult(array $list): int
    {
        return count(
            array_filter(
                $list,
                static fn (int $el) => self::OWN_GOAL !== $el
            )
        );
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

        return 'X';
    }
}
