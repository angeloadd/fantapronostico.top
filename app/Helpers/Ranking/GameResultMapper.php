<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use App\Models\Player;
use App\Models\Prediction;

final class GameResultMapper
{
    public static function map(Prediction $prediction): GameResult
    {
        $game = $prediction->game;

        $closure = static function (int $scorerId): string {
            $player = Player::find($scorerId);

            return $player->name . ' (' . __($player->team->name) . ')';
        };

        return new GameResult(
            PredictionScoreFactory::create($prediction),
            $game->id,
            $game->home_score,
            $game->away_score,
            $game->sign,
            array_map($closure, $game->home_scorers),
            array_map($closure, $game->away_scorers)
        );
    }
}
