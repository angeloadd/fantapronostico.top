<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use App\Models\Game;
use App\Models\Prediction;
use App\Models\Tournament;
use App\Modules\Auth\Models\User;
use Carbon\Carbon;

final class UserRank
{
    private const RESULT_POINTS = 4;

    private const SCORER_POINTS = 2;

    private const SIGN_POINTS = 1;

    private int $total;

    private int $finalBetTimestamp;

    private int $finalBetTotal;

    private bool $winnerTeam;

    private bool $topScorer;

    private int $numberOfResults;

    private int $numberOfSigns;

    private int $numberOfScorers;

    public function __construct(private readonly User $user)
    {
        $this->total = 0;
        $this->numberOfResults = 0;
        $this->numberOfSigns = 0;
        $this->numberOfScorers = 0;
        $this->finalBetTimestamp = 0;
        $this->finalBetTotal = 0;
        $this->winnerTeam = false;
        $this->topScorer = false;
        $this->calculate();
    }

    public function calculate(): self
    {
        $this->calculateResultsV2();
        //        $this->calculateSigns();
        //        $this->calculateScorers();
        //        $this->getFinalBetInfo();
        $this->getChampionInfo();
        $this->calculateTotal();

        return $this;
    }

    public function calculateResultsV2(): void
    {
        if (null === $this->user->predictions) {
            return;
        }
        $result = $this->user->predictions->reduce(
            static function (array $acc, Prediction $bet) {
                $game = $bet->game;

                if (isset($game->home_result, $game->away_result) &&
                    $game->home_result === $bet->home_result &&
                    $game->away_result === $bet->away_result
                ) {
                    if ($game->isFinal()) {
                        $acc['finalTotal'] += self::RESULT_POINTS;
                    }
                    $acc['results']++;
                }

                $sign = $bet->game->sign;

                if (isset($sign) && $sign === $bet->sign) {
                    if ($game->isFinal()) {
                        $acc['finalTotal'] += self::SIGN_POINTS;
                    }
                    $acc['signs']++;
                }

                if (in_array(
                    $bet->home_score,
                    $game->home_score ?? [],
                    true
                )) {
                    if ($game->isFinal()) {
                        $acc['finalTotal'] += self::SCORER_POINTS;
                    }
                    $acc['scorers']++;
                }

                if (in_array(
                    $bet->away_score,
                    $game->away_score ?? [],
                    true
                )) {
                    if ($game->isFinal()) {
                        $acc['finalTotal'] += self::SCORER_POINTS;
                    }
                    $acc['scorers']++;
                }

                if ($game->isFinal()) {
                    $acc['finalTimestamp'] = Carbon::create($bet->updated_at)->unix();
                }

                return $acc;
            },
            [
                'results' => 0,
                'signs' => 0,
                'scorers' => 0,
                'finalTotal' => 0,
                'finalTimestamp' => 0,
            ]
        );

        $this->numberOfScorers = $result['scorers'];
        $this->numberOfSigns = $result['signs'];
        $this->numberOfResults = $result['results'];
        $this->finalBetTimestamp = $result['finalTimestamp'];
        $this->finalBetTotal = $result['finalTotal'];
    }

    public function calculateResultOfTheBet(Prediction $bet): int
    {
        $game = $bet->game;
        $result = 0;
        if (isset($game, $game->home_result, $game->away_result, $game->sign)) {
            if ($game->home_result === $bet?->home_result && $game->away_result === $bet?->away_result) {
                $result += self::RESULT_POINTS;
            }
            if ($game->sign === $bet->sign) {
                $result += +self::SIGN_POINTS;
            }
            if (in_array($bet->home_score, $game->home_score ?? [], true)) {
                $result += self::SCORER_POINTS;
            }
            if (in_array($bet->away_score, $game->away_score ?? [], true)) {
                $result += self::SCORER_POINTS;
            }
        }

        return $result;
    }

    public function finalBetTimestamp(): int
    {
        return $this->finalBetTimestamp;
    }

    public function finalBetTotal(): int
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

    public function user(): User
    {
        return $this->user;
    }

    public function winner(): int
    {
        return $this->winnerTeamTot();
    }

    public function top(): int
    {
        return $this->topScorerTot();
    }

    private function calculateResults(): void
    {
        $this->numberOfResults = $this->user->predictions->reduce(
            static function (int $result, Prediction $bet) {
                $game = $bet->game;

                if (isset($game->home_result, $game->away_result) &&
                    $game->home_result === $bet->home_result &&
                    $game->away_result === $bet->away_result
                ) {
                    $result++;
                }

                return $result;
            },
            0
        );
    }

    private function calculateSigns(): void
    {
        $this->numberOfSigns = $this->user->predictions->reduce(
            static function (int $result, Prediction $bet) {
                $sign = $bet->game->sign;

                return isset($sign) && $sign === $bet->sign ? $result + self::SIGN_POINTS : $result;
            },
            0
        );
    }

    private function calculateScorers(): void
    {
        $this->numberOfScorers = $this->user->predictions->reduce(
            static function (int $result, Prediction $bet) {
                $game = $bet->game;
                if (in_array(
                    $bet->home_score,
                    $game->home_score ?? [],
                    true
                )) {
                    $result++;
                }

                if (in_array(
                    $bet->away_score,
                    $game->away_score ?? [],
                    true
                )) {
                    $result++;
                }

                return $result;
            },
            0
        );
    }

    private function getFinalBetInfo(): void
    {
        $final = Game::where('type', 'final')->first();
        $bet = Prediction::where('game_id', $final?->id)
            ->where('user_id', $this->user->id)
            ->first();

        if (isset($bet)) {
            $this->finalBetTimestamp = (new Carbon($bet->updated_at))->unix();
            $this->calculateFinalTotal($final, $bet);
        } else {
            $this->finalBetTotal = 0;
            $this->finalBetTimestamp = 0;
        }
    }

    private function getChampionInfo(): void
    {
        $winner = Tournament::first()->teams->where('is_winner', true)->first();
        $topScorer = Tournament::first()->players->where('is_top_scorer', true)->first();
        $champion = $this->user->champion;
        if ($champion && $champion->team_id === $winner?->id) {
            $this->winnerTeam = true;
        }
        if ($champion && $topScorer && $topScorer->id === $champion->player_id) {
            $this->topScorer = true;
        }
    }

    private function calculateTotal(): void
    {
        $this->total = $this->resultsTot() +
            $this->signsTot() +
            $this->scorerTot() +
            $this->winnerTeamTot() +
            $this->topScorerTot();
    }

    private function calculateFinalTotal(?Game $final, Prediction $bet): void
    {
        if ( ! isset($final, $final->home_result, $final->away_result, $final->sign)) {
            $this->finalBetTotal = 0;
        } else {
            $result = 0;
            if ($final->home_result === $bet?->home_result && $final->away_result === $bet?->away_result) {
                $result += self::RESULT_POINTS;
            }
            if ($final->sign === $bet->sign) {
                $result += +self::SIGN_POINTS;
            }
            if (in_array($bet->home_score, $final->home_score ?? [], true)) {
                $result += self::SCORER_POINTS;
            }
            if (in_array($bet->away_score, $final->away_score ?? [], true)) {
                $result += self::SCORER_POINTS;
            }

            $this->finalBetTotal = $result;
        }
    }

    private function resultsTot(): int
    {
        return $this->numberOfResults * self::RESULT_POINTS;
    }

    private function signsTot(): int
    {
        return $this->numberOfSigns * self::SIGN_POINTS;
    }

    private function scorerTot(): int
    {
        return $this->numberOfScorers * self::SCORER_POINTS;
    }

    private function winnerTeamTot(): int
    {
        return $this->winnerTeam ? 15 : 0;
    }

    private function topScorerTot(): int
    {
        return $this->topScorer ? 10 : 0;
    }
}
