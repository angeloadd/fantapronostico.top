<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\Ranking\RankingCalculatorInterface;
use App\Helpers\Ranking\UserRank;
use App\Models\Game;
use App\Models\Tournament;
use App\Modules\Auth\Models\User;
use App\Modules\Auth\Repository\UserRepositoryInterface;
use App\Modules\League\Models\League;
use App\Repository\Game\GameRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

final class HomeController extends Controller
{
    public function __construct(
        private readonly RankingCalculatorInterface $calculator,
        private readonly GameRepositoryInterface $gameRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function index(Request $request): Renderable
    {
        $user = $this->userRepository->getAuthenticatedUser();

        $league = $request->league;

        if (!$user instanceof User || !$league instanceof League) {
            throw new UnauthorizedHttpException('You shall not pass!!');
        }

        $tournament = $league->tournament;
        $ranking = $this->calculator->get($league);
        $nextGame = Game::where('started_at', '>', now())
            ->get()
            ->groupBy('started_at')
            ->first()
            ?->filter(static fn (Game $game) => $game->predictions->firstWhere('user_id', $user->id) === null)
            ->first();

        return view('pages.home.index', [
            'ranking' => $ranking->filter(static fn (UserRank $rank, int $index) => $user->id === $rank->userId() || $index <= 12),
            'nextGame' => $nextGame,
            'champion' => $user->champion,
            'hasTournamentStarted' => $this->hasTournamentStarted($tournament),
            'hasFinalStarted' => $this->hasFinalStarted($tournament),
            'lastResults' => $this->gameRepository->getLastResults(now()),
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
