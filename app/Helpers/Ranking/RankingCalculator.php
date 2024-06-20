<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use App\Models\Prediction;
use App\Modules\Auth\Models\User;
use App\Modules\League\Models\League;
use DB;
use Illuminate\Support\Collection;
use stdClass;

final readonly class RankingCalculator implements RankingCalculatorInterface
{
    public function __construct(private SorterInterface $sorter)
    {
    }

    public function calculate(League $league): void
    {
        $league->users
            ->filter(static fn (User $user) => 'accepted' === $user->pivot->status)
            ->each(
                function (User $user) use ($league): void {
                    $rank = $this->calculateUserRank($user, $league);

                    DB::table('ranks')->updateOrInsert(
                        ['user_id' => $rank->userId()],
                        [
                            'user_id' => $rank->userId(),
                            'league_id' => $league->id,
                            'total' => $rank->total(),
                            'results' => $rank->results(),
                            'scorers' => $rank->scorers(),
                            'signs' => $rank->signs(),
                            'final_total' => $rank->finalPredictionTotal(),
                            'final_timestamp' => 0 === $rank->finalPredictionTimestamp() ? null : $rank->finalPredictionTimestamp(),
                            'winner' => $rank->winner(),
                            'top_scorer' => $rank->topScorer(),
                        ]
                    );
                }
            );
    }

    public function get(League $league): Collection
    {
        $ranking = DB::table('ranks')
            ->where('league_id', $league->id)
            ->get()
            ->map(
                static fn (stdClass $rank) => new UserRank(
                    $rank->user_id,
                    User::find($rank->user_id)->name,
                    $league->id,
                    $rank->total,
                    $rank->results,
                    $rank->signs,
                    $rank->scorers,
                    $rank->final_total ?? 0,
                    $rank->final_timestamp ?? 0,
                    $rank->winner,
                    $rank->top_scorer
                )
            );

        return $this->sorter->sortAggregate($ranking);
    }

    private function calculateUserRank(User $user, League $league): UserRank
    {
        $rank = new UserRank(
            $user->id,
            $user->name,
            $league->id
        );

        $rank = $this->calculatePredictionScores($user, $league, $rank);

        return $this->addWinnerAndTopScorerScores($user, $league, $rank);
    }

    private function calculatePredictionScores(User $user, League $league, UserRank $rank): UserRank
    {
        return $user->predictions
            ?->whereStrict('league_id', $league->id)
            ?->filter(fn (Prediction $prediction) => 'finished' === $prediction->game->status)
            ?->map(fn (Prediction $prediction) => PredictionScoreFactory::create($prediction))
            ?->reduce(function (UserRank $rank, PredictionScore $prediction): UserRank {
                if ($prediction->result) {
                    $rank->numberOfResults++;
                }

                if ($prediction->sign) {
                    $rank->numberOfSigns++;
                }

                if ($prediction->homeScorer) {
                    $rank->numberOfScorers++;
                }

                if ($prediction->awayScorer) {
                    $rank->numberOfScorers++;
                }

                if ($prediction->isFinal) {
                    $rank->finalBetTimestamp = $prediction->timestamp;
                    $rank->finalBetTotal = $prediction->total();
                }

                $rank->total += $prediction->total();

                return $rank;
            }, $rank);
    }

    private function addWinnerAndTopScorerScores(User $user, League $league, UserRank $rank): UserRank
    {
        $tournament = $league->tournament;
        $winner = $tournament->teams?->where('is_winner', true)?->first();
        if (null === $winner) {
            return $rank;
        }
        $topScorer = $tournament->players?->where('is_top_scorer', true)?->first();

        if (null === $topScorer) {
            return $rank;
        }

        $champion = $user->champion;
        if (null === $champion) {
            return $rank;
        }
        if ($champion->team_id === $winner->id) {
            $rank->winner = true;
            $rank->total += 15;
        }
        if ($topScorer->id === $champion->player_id) {
            $rank->topScorer = true;
            $rank->total += 10;
        }

        return $rank;
    }
}
