<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use App\Models\Prediction;

final class PredictionScoreMapper
{
    public function __construct(private readonly GameResultMapper $gameResultMapper)
    {

    }

    public function map(Prediction $prediction): PredictionScore
    {
        return new PredictionScore(
            $this->gameResultMapper->map($prediction->game),
            $prediction->id,
            $prediction->user_id,
            true,
            2,
            2,
        );
    }
}
