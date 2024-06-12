<?php

declare(strict_types=1);

namespace App\Repository\Game;

use App\Models\Game;
use DateTimeInterface;
use Illuminate\Support\Collection;

interface GameRepositoryInterface
{
    public function areGameTeamsSet(Game $game): bool;

    public function getLastThreeGames(DateTimeInterface $dateTime): Collection;

    public function getNextGame(): ?Game;

    public function getNextGameByOtherGame(Game $game): ?Game;

    public function getPreviousGameByOtherGame(Game $game): ?Game;

    public function getAll(): Collection;
}
