<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Game;
use App\Repository\Game\GameRepositoryInterface;
use App\Service\TimeManagementServiceInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class GameNotAccessibleAction extends Controller
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private TimeManagementServiceInterface $timeManagementService
    ) {
    }

    public function __invoke(Request $request, ?Game $game = null): RedirectResponse|Renderable
    {
        $gameRef = $game ?? $this->gameRepository->getNextGameByDateTime($this->timeManagementService->now());

        if ( ! isset($gameRef)) {
            redirect(route('errors.gameNotSet'))
                ->with('error_message', 'L\'incontro non è disponibile');
        }

        return view(
            'errors.nextGame.notAccessible',
            [
                'games' => Game::all(),
                'game' => $gameRef,
            ]
        );
    }
}
