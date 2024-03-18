<?php

declare(strict_types=1);

namespace App\Repository\Bet;

use App\Models\Bet;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Collection;

final class BetRepository implements BetRepositoryInterface
{
    public function getSortedDescByUpdatedAtByGame(Game $game): Collection
    {
        return $game->bets->sortByDesc('updated_at')->values();
    }

    public function getByUser(User $user): Collection
    {
        return $user->bets;
    }

    public function getByGameAndUser(Game $game, User $user): ?Bet
    {
        return $game->bets->where('user_id', $user->id)
            ->first();
    }

    public function existsByGameAndUser(Game $game, User $user): bool
    {
        return Bet::where('game_id', $game->id)->where('user_id', $user->id)->exists();
    }
}
