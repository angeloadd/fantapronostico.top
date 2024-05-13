<?php

declare(strict_types=1);

namespace App\Repository\Bet;

use App\Models\Bet;
use App\Models\Game;
use App\Modules\Auth\Models\User;
use Illuminate\Support\Collection;

interface BetRepositoryInterface
{
    public function getSortedDescByUpdatedAtByGame(Game $game): Collection;

    public function getByUser(User $user): Collection;

    public function getByGameAndUser(Game $game, User $user): ?Bet;

    public function existsByGameAndUser(Game $game, User $user): bool;
}
