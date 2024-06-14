<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use App\Models\Game;
use App\Models\Prediction;

final readonly class PredictionScoreFactory
{
    public static function create(Prediction $prediction): PredictionScore
    {
        $game = $prediction->game;

        return new PredictionScore(
            $game->sign === $prediction->sign,
            $game->home_score === $prediction->home_score && $game->away_score === $prediction->away_score,
            self::getHomeScorerPredictionResult($prediction, $game),
            self::getAwayScorerPredictionResult($prediction, $game),
            $game->isFinal(),
            $prediction->updated_at->unix(),
        );
    }

    private static function getHomeScorerPredictionResult(Prediction $prediction, Game $game): bool
    {
        if ($prediction->home_scorer_id === -1) {
            return in_array($prediction->home_scorer_id, $game->away_scorers, true);
        }

        return in_array($prediction->home_scorer_id, $game->home_scorers, true);
    }

    private static function getAwayScorerPredictionResult(Prediction $prediction, Game $game): bool
    {
        if ($prediction->away_scorer_id === -1) {
            return in_array($prediction->away_scorer_id, $game->home_scorers, true);
        }

        return in_array($prediction->away_scorer_id, $game->away_scorers, true);
    }
}
