<?php

declare(strict_types=1);

namespace App\Repository\Prediction;

use App\Models\Game;
use App\Models\Prediction;
use App\Modules\Auth\Models\User;
use Illuminate\Support\Collection;

interface PredictionRepositoryInterface
{
    public function getSortedDescByUpdatedAtByGame(Game $game): Collection;

    public function getByUser(User $user): Collection;

    public function getByGameAndUser(Game $game, User $user): ?Prediction;

    public function existsByGameAndUser(Game $game, User $user): bool;
}
