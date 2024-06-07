<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use App\Models\Game;
use InvalidArgumentException;

final class GameResultMapper
{
    public function map(Game $game): GameResult
    {
        if ('finished' !== $game->status) {
            throw new InvalidArgumentException('Game is not finished');
        }

        return new GameResult(
            $game->id,
            $game->home_score,
            $game->away_score,
            $game->home_scorers->map(fn (int $id) => $id)->toArray(),
            $game->away_scorers->map(fn (int $id) => $id)->toArray()
        );

    }
}
