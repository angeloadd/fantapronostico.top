<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use InvalidArgumentException;

final readonly class PredictionScore
{
    public function __construct(
        public GameResult $gameResult,
        public int $userId,
        public int $predictionId,
        public bool $sign,
        public int $numberOfResult,
        public int $numberOfScorer,
    ) {
        if ($this->numberOfResult > 2 || $this->numberOfScorer > 2) {
            throw new InvalidArgumentException(sprintf('Invalid number of result[%s] or scorer[%s]', $this->numberOfResult, $this->numberOfScorer));
        }
    }
}
