<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use App\Modules\Auth\Models\User;
use App\Modules\League\Models\League;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class RankingCalculator implements RankingCalculatorInterface
{
    public function get(League $league): Collection
    {
        $ranks = $league
            ->users
            ->filter(static fn (User $user) => 'accepted' === $user->pivot->status)
            ->map(static fn (User $user): UserRank => (new UserRank($user->id, $user->name, $league->id))->calculate());
        return (new Sorter())(
            $ranks,
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
