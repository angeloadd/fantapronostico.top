<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use App\Modules\Auth\Models\User;
use App\Modules\League\Models\League;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class RankingCalculator implements RankingCalculatorInterface
{
    public function get(): Collection
    {
        return Cache::remember(
            'usersRank',
            now()->addDay(),
            static function () {
                $users = League::first()
                    ->users
                    ->filter(static fn (User $user) => 'accepted' === $user->pivot->status);

                return Collection::sortByMulti(
                    $users->map(static fn (User $user): UserRank => (new UserRank($user))->calculate()),
                    [
                        static fn (UserRank $item): int => $item->total(),
                        static fn (UserRank $item): int => $item->results(),
                        static fn (UserRank $item): int => $item->scorers(),
                        static fn (UserRank $item): int => $item->signs(),
                        static fn (UserRank $item): int => $item->finalBetTotal(),
                        static fn (UserRank $item): int => $item->finalBetTimestamp(),
                        static fn (UserRank $item): string => $item->userName(),
                    ]
                )->flatten()
                    ->values();
            }
        );
    }
}
