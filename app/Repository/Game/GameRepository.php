<?php

declare(strict_types=1);

namespace App\Repository\Game;

use App\Models\Game;
use DateTimeInterface;
use Illuminate\Support\Collection;

final class GameRepository implements GameRepositoryInterface
{
    public function getNextGameByDateTime(DateTimeInterface $dateTime): ?Game
    {
        $game = Game::where('started_at', '>', $dateTime)
            ->first();

        return $game instanceof Game ? $game : null;
    }

    public function nextGameExists(DateTimeInterface $dateTime): bool
    {
        return Game::where('started_at', '>', $dateTime)->exists();
    }

    public function getAll(): Collection
    {
        return Game::all();
    }

    public function areGameTeamsSet(Game $game): bool
    {
        return isset($game->home_team, $game->away_team);
    }

    public function getPreviousGameByOtherGame(Game $game): ?Game
    {
        $gamesFromDb = Game::orderBy('id')
            ->where('started_at', $game->started_at)->get();

        if (0 === $gamesFromDb->count()) {
            return null;
        }

        if ($gamesFromDb->count() > 1 && $game->id === $gamesFromDb->last()->id) {
            return $gamesFromDb->first();
        }

        return Game::fromLatest()->where('started_at', '<', $game->started_at)->first();
    }

    public function getNextGameByOtherGame(Game $game): ?Game
    {
        $gamesFromDb = Game::orderBy('id')
            ->where('started_at', $game->started_at)->get();

        if (0 === $gamesFromDb->count()) {
            return null;
        }

        if ($gamesFromDb->count() > 1 && $game->id === $gamesFromDb->first()->id) {
            return $gamesFromDb->last();
        }

        return Game::where('started_at', '>', $game->started_at)->first();
    }

    public function getLastThreeGames(DateTimeInterface $dateTime): Collection
    {
        return Game::lastThreeGames($dateTime)->get();
    }
}
