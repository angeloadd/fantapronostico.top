<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Game;
use App\Repository\Game\GameRepositoryInterface;
use App\Service\TimeManagementServiceInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

final class GameNotAccessibleAction extends Controller
{
    public function __construct(
        private readonly GameRepositoryInterface $gameRepository,
        private readonly TimeManagementServiceInterface $timeManagementService
    ) {
    }

    public function __invoke(Request $request, ?Game $game = null): Renderable
    {
        $gameRef = $game ?? $this->gameRepository->getNextGameByDateTime($this->timeManagementService->now());

        if ( ! isset($gameRef)) {
            abort(404);
        }

        return view(
            'pages.prediction.409',
            [
                'games' => Game::all(),
                'game' => $gameRef,
            ]
        );
    }
}
