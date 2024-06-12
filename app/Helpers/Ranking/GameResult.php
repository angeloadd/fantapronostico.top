<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

final readonly class GameResult
{
    public function __construct(
        public PredictionScore $predictionScore,
        public int $gameId,
        public int $homeScore,
        public int $awayScore,
        public string $sign,
        public array $homeScorers,
        public array $awayScorers
    ) {
    }
}
