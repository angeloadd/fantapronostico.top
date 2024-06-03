<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Helpers\Ranking\RankingCalculatorInterface;
use App\Models\Game;
use App\Repository\Game\GameRepositoryInterface;
use App\Service\TimeManagementServiceInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Carbon;
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

        return view('homepage', [
            'ranking' => $collection,
            'nextGame' => $nextGame,
            'isDeadlineForChampionBetPassed' => $this->isDeadlineForChampionBetPassed(),
            'isFinalStarted' => $this->isFinalStarted(),
            'areGameTeamsSet' => isset($nextGame) && $this->areGameTeamsSet($nextGame),
            'lastThreeGames' => $this->gameRepository->getLastThreeGames($this->timeManagementService->now()),
        ]);
    }

    private function isWinnerDeclared(): bool
    {
        return now()->gt(Carbon::createFromTimestamp(Constants::FINAL_DATE)->addHours(2)) &&
            Game::all()->every('status', '=', 'completed');
    }

    private function isDeadlineForChampionBetPassed(): bool
    {
        $game = Game::first();

        return null !== $game && $game->started_at->lte(now());
    }

    private function isFinalStarted(): bool
    {
        return time() >= Constants::FINAL_DATE;
    }

    private function areGameTeamsSet($nextGame): bool
    {
        return isset($nextGame?->home_team, $nextGame?->away_team);
    }
}
