<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use App\Modules\Auth\Models\User;
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
                return Collection::sortByMulti(
                    User::all()->map(static fn (User $user): UserRank => new UserRank($user)),
                    [
                        static fn (UserRank $item): int => $item->total(),
                        static fn (UserRank $item): int => $item->results(),
                        static fn (UserRank $item): int => $item->scorers(),
                        static fn (UserRank $item): int => $item->signs(),
                        static fn (UserRank $item): int => $item->finalBetTotal(),
                        static fn (UserRank $item): int => $item->finalBetTimestamp(),
                        static fn (UserRank $item): string => $item->user()->name,
                    ]
                )->flatten()
                    ->values();
            }
        );
    }

    public function backup(): Collection
    {
        return User::all()->map(static fn (User $user): UserRank => new UserRank($user))
            ->sortByDesc(static fn (UserRank $a): int => $a->total())
            ->groupBy(static fn (UserRank $item): int => $item->total())
            ->map(static function (Collection $collection): Collection {
                return $collection->sortByDesc(static fn (UserRank $a): int => $a->results())
                    ->groupBy(static fn (UserRank $item): int => $item->results())
                    ->map(static function (Collection $collection): Collection {
                        return $collection->sortByDesc(static fn (UserRank $a): int => $a->scorers())
                            ->groupBy(static fn (UserRank $item): int => $item->scorers())
                            ->map(static function (Collection $collection): Collection {
                                return $collection->sortByDesc(static fn (UserRank $a): int => $a->signs())
                                    ->groupBy(static fn (UserRank $item): int => $item->signs())
                                    ->map(static function (Collection $collection): Collection {
                                        return $collection->sortByDesc(
                                            static fn (UserRank $a): int => $a->finalBetTotal()
                                        )
                                            ->groupBy(static fn (UserRank $item): int => $item->finalBetTotal())
                                            ->map(static function (Collection $collection): Collection {
                                                return $collection->sortByDesc(
                                                    static fn (UserRank $a): int => $a->finalBetTimestamp()
                                                )
                                                    ->groupBy(
                                                        static fn (UserRank $item): int => $item->finalBetTimestamp()
                                                    )
                                                    ->map(static function (Collection $collection): Collection {
                                                        return $collection->sortByDesc(
                                                            static fn (UserRank $a): string => $a->user()->name
                                                        );
                                                    });
                                            });
                                    });
                            });
                    });
            })->flatten()->values();
    }
}
