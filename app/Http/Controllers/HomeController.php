<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\Ranking\RankingCalculatorInterface;
use App\Helpers\Ranking\UserRank;
use App\Models\Game;
use App\Models\Tournament;
use App\Repository\Game\GameRepositoryInterface;
use App\Service\TimeManagementServiceInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

final class HomeController extends Controller
{
    public function __construct(
        private readonly RankingCalculatorInterface $calculator,
        private readonly GameRepositoryInterface $gameRepository,
        private readonly TimeManagementServiceInterface $timeManagementService,
    ) {
    }

    public function index(): Renderable
    {
        $collection = $this->calculator->get();
        if ($this->isWinnerDeclared()) {
            return view('winner', ['ranking' => $collection]);
        }

        $nextGame = $this->gameRepository->getNextGameByDateTime($this->timeManagementService->now());
        if (isset($nextGame) &&
            Auth::user() &&
            Game::where('started_at', $nextGame->started_at)->count() > 1 &&
            null !== $nextGame->predictions?->where('user_id', Auth::user()->id)?->first()
        ) {
            $nextGame = $this->gameRepository->getNextGameByOtherGame($nextGame);
        }

        return view('pages.home.index', [
            'ranking' => $collection->filter(static fn (UserRank $rank, int $index) => Auth::user()?->id === $rank->user()->id || $index <= 13),
            'nextGame' => $nextGame,
            'champion' => auth()->user()->champion,
            'hasTournamentStarted' => $this->hasTournamentStarted(),
            'hasFinalStarted' => $this->hasFinalStarted(),
            'lastResults' => $this->gameRepository->getLastThreeGames($this->timeManagementService->now()),
        ]);
    }

    private function isWinnerDeclared(): bool
    {
        return Tournament::first()?->final_started_at->addHours(2)->isPast() &&
            Game::all()->every('status', '=', 'completed');
    }

    private function hasTournamentStarted(): bool
    {
        $game = Game::first();

        return null !== $game && $game->started_at->lte(now());
    }

    private function hasFinalStarted(): bool
    {
        return Tournament::first()?->final_started_at->isPast();
    }

    private function areGameTeamsSet($nextGame): bool
    {
        return isset($nextGame?->home_team, $nextGame?->away_team);
    }
}
