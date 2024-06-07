<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use App\Models\Prediction;
use App\Models\Tournament;
use App\Modules\Auth\Models\User;
use Carbon\Carbon;
use Throwable;

final class UserRank
{
    private const RESULT_POINTS = 4;

    private const SCORER_POINTS = 2;

    private const SIGN_POINTS = 1;

    public function __construct(
        private readonly User $user,
        private int $total = 0,
        private int $numberOfResults = 0,
        private int $numberOfSigns = 0,
        private int $numberOfScorers = 0,
        private int $finalBetTimestamp = 0,
        private int $finalBetTotal = 0,
        private bool $winnerTeam = false,
        private bool $topScorer = false,
    ) {
    }

    public function calculate(): self
    {
        $this->calculateResult();
        $this->getChampionInfo();
        $this->calculateTotal();

        return $this;
    }

    public function calculateResult(): void
    {
        if (null === $this->user->predictions) {
            return;
        }
        $result = $this->user->predictions()->with(['game'])->get()->filter(fn (Prediction $bet) => 'finished' === $bet->game->status)->reduce(
            static function (array $acc, Prediction $bet) {
                try {
                    $game = $bet->game;

                    if ($game->home_score === $bet->home_score &&
                        $game->away_score === $bet->away_score
                    ) {
                        if ($game->isFinal()) {
                            $acc['finalTotal'] += self::RESULT_POINTS;
                        }
                        $acc['results']++;
                    }

                    $sign = $bet->game->sign;

                    if ($sign === $bet->sign) {
                        if ($game->isFinal()) {
                            $acc['finalTotal'] += self::SIGN_POINTS;
                        }
                        $acc['signs']++;
                    }

                    if (in_array(
                        $bet->home_scorer_id,
                        $game->home_scorers ?? [],
                        true
                    )) {
                        if ($game->isFinal()) {
                            $acc['finalTotal'] += self::SCORER_POINTS;
                        }
                        $acc['scorers']++;
                    }

                    if (in_array(
                        $bet->away_scorer_id,
                        $game->away_scorers ?? [],
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
                } catch (Throwable $e) {
                    dump($e);
                    throw $e;
                }
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

    public function winner(): int
    {
        return $this->winnerTeamTot();
    }

    public function top(): int
    {
        return $this->topScorerTot();
    }

    public function userName(): string
    {
        return $this->user->name;
    }

    public function userId(): int
    {
        return $this->user->id;
    }

    private function getChampionInfo(): void
    {
        $winner = Tournament::first()?->teams?->where('is_winner', true)?->first();
        if (null === $winner) {
            return;
        }
        $topScorer = Tournament::first()?->players?->where('is_top_scorer', true)?->first();

        if (null === $topScorer) {
            return;
        }
        $champion = $this->user->champion;
        if (null === $champion) {
            return;
        }
        if ($champion->team_id === $winner->id) {
            $this->winnerTeam = true;
        }
        if ($topScorer->id === $champion->player_id) {
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

    public function user(): User
    {
        return $this->user;
    }
}
