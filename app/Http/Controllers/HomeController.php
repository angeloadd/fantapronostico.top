<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\Ranking\RankingCalculatorInterface;
use App\Helpers\Ranking\UserRank;
use App\Models\Game;
use App\Models\Tournament;
use App\Repository\Game\GameRepositoryInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class HomeController extends Controller
{
    public function __construct(
        private readonly RankingCalculatorInterface $calculator,
        private readonly GameRepositoryInterface $gameRepository,
    ) {
    }

    public function index(): Renderable
    {
        $league = Request::getCurrentLeague();
        $tournament = $league->tournament;
        $ranking = $this->calculator->get($league);
        $nextGame = $this->gameRepository->getNextGame();
        if (isset($nextGame) &&
            Auth::user() &&
            Game::where('started_at', $nextGame->started_at)->count() > 1 &&
            null !== $nextGame->predictions?->where('user_id', Auth::user()->id)?->first()
        ) {
            $nextGame = $this->gameRepository->getNextGameByOtherGame($nextGame);
        }

        return view('pages.home.index', [
            'ranking' => $ranking->filter(static fn (UserRank $rank, int $index) => Auth::user()?->id === $rank->userId() || $index <= 12),
            'nextGame' => $nextGame,
            'champion' => auth()->user()->champion,
            'hasTournamentStarted' => $this->hasTournamentStarted($tournament),
            'hasFinalStarted' => $this->hasFinalStarted($tournament),
            'lastResults' => $this->gameRepository->getLastThreeGames(now()),
            'isWinnerDeclared' => $this->isWinnerDeclared($tournament),
            'winnerName' => $ranking->first()->userName(),
            'leagueName' => $league->name,
            'games' => $this->gameRepository->getAll(),
        ]);
    }

    private function isWinnerDeclared(Tournament $tournament): bool
    {
        return $tournament->final_started_at->isPast() &&
            $tournament->games->every('status', '=', 'completed');
    }

    private function hasTournamentStarted(Tournament $tournament): bool
    {
        return $tournament->started_at->lte(now());
    }

    private function hasFinalStarted(Tournament $tournament): bool
    {
        return $tournament->final_started_at->isPast();
    }
}
