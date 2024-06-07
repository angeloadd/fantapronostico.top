<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

final readonly class GameResult
{
    /**
     * @param  int[]  $homeScorerIds
     * @param  int[]  $awayScorerIds
     */
    public function __construct(
        public int $gameId,
        public int $homeScore,
        public int $awayScore,
        public array $homeScorerIds,
        public array $awayScorerIds,
    ) {
    }
}
