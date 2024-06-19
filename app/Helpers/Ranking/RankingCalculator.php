<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use App\Modules\Auth\Models\User;
use App\Modules\League\Models\League;
use DB;
use Illuminate\Support\Collection;
use stdClass;

final class RankingCalculator implements RankingCalculatorInterface
{
    public function calculate(League $league): Collection
    {
        $ranks = $league
            ->users
            ->filter(static fn (User $user) => 'accepted' === $user->pivot->status)
            ->map(static fn (User $user): UserRank => (new UserRank($user->id, $user->name, $league->id))->calculate());

        $ranking = $ranks->map(static fn (UserRank $rank) => [
            'user_id' => $rank->userId(),
            'league_id' => $league->id,
            'total' => $rank->total(),
            'results' => $rank->results(),
            'scorers' => $rank->scorers(),
            'signs' => $rank->signs(),
            'final_total' => $rank->finalPredictionTotal(),
            'final_timestamp' => 0 === $rank->finalPredictionTimestamp() ? null : $rank->finalPredictionTimestamp(),
        ]);

        foreach ($ranking as $rank) {
            DB::table('ranks')->updateOrInsert(['user_id' => $rank['user_id']], $rank);
        }

        return $ranking;
    }

    public function get(League $league): Collection
    {
        $ranking = DB::table('ranks')->where('league_id', $league->id)->get()->map(
            static fn (stdClass $rank) => new UserRank(
                $rank->user_id,
                User::find($rank->user_id)->name,
                $league->id,
                $rank->total,
                $rank->results,
                $rank->signs,
                $rank->scorers,
                $rank->final_total ?? 0,
                $rank->final_timestamp ?? 0
            )
        );

        return (new Sorter())(
            $ranking,
            [
                static fn (UserRank $userRank): int => $userRank->total(),
                static fn (UserRank $userRank): int => $userRank->results(),
                static fn (UserRank $userRank): int => $userRank->scorers(),
                static fn (UserRank $userRank): int => $userRank->signs(),
                static fn (UserRank $userRank): int => $userRank->finalPredictionTotal(),
                static fn (UserRank $userRank): int => $userRank->finalPredictionTimestamp(),
                static fn (UserRank $userRank): string => $userRank->userName(),
            ]
        );
    }
}
