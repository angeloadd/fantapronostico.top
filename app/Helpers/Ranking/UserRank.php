<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use App\Models\Prediction;
use App\Modules\Auth\Models\User;
use App\Modules\League\Models\League;

final class UserRank
{
    public const TOP_SCORER_POINTS = 10;

    private const WINNER_TEAM_POINTS = 15;

    public function __construct(
        public readonly int $userId,
        public readonly string $userName,
        public readonly int $leagueId,
        private int $total = 0,
        private int $numberOfResults = 0,
        private int $numberOfSigns = 0,
        private int $numberOfScorers = 0,
        private int $finalBetTimestamp = 0,
        private int $finalBetTotal = 0,
    ) {
    }

    public function calculate(): self
    {
        $this->calculateResult();
        $this->addWinnerAndTopScorerScores();

        return $this;
    }

    public function finalPredictionTimestamp(): int
    {
        return $this->finalBetTimestamp;
    }

    public function finalPredictionTotal(): int
    {
        return $this->finalBetTotal;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function results(): int
    {
        return $this->numberOfResults;
    }

    public function signs(): int
    {
        return $this->numberOfSigns;
    }

    public function scorers(): int
    {
        return $this->numberOfScorers;
    }

    public function userName(): string
    {
        return $this->userName;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    private function calculateResult(): void
    {
        $user = User::find($this->userId);
        if (null === $user->predictions) {
            return;
        }

        //TODO: Relation league_prediction
        $predictions = $user->predictions->filter(fn (Prediction $prediction) => 'finished' === $prediction->game->status);
        $predictions = $predictions->map(fn (Prediction $prediction) => PredictionScoreFactory::create($prediction));

        $predictions->each(function (PredictionScore $prediction) {
            if ($prediction->result) {
                $this->numberOfResults++;
            }

            if ($prediction->sign) {
                $this->numberOfSigns++;
            }

            if ($prediction->homeScorer) {
                $this->numberOfScorers++;
            }

            if ($prediction->awayScorer) {
                $this->numberOfScorers++;
            }

            if ($prediction->isFinal) {
                $this->finalBetTimestamp = $prediction->timestamp;
                $this->finalBetTotal = $prediction->total();
            }

            $this->total += $prediction->total();

            return $this;
        });
    }

    private function addWinnerAndTopScorerScores(): void
    {
        $tournament = League::find($this->leagueId)->tournament;
        $winner = $tournament->teams?->where('is_winner', true)?->first();
        if (null === $winner) {
            return;
        }
        $topScorer = $tournament->players?->where('is_top_scorer', true)?->first();

        if (null === $topScorer) {
            return;
        }
        $champion = $this->user->champion;
        if (null === $champion) {
            return;
        }
        if ($champion->team_id === $winner->id) {
            $this->total += self::WINNER_TEAM_POINTS;
        }
        if ($topScorer->id === $champion->player_id) {
            $this->total += self::TOP_SCORER_POINTS;
        }
    }
}
