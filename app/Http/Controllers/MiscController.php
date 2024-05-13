<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\Ranking\RankingCalculatorInterface;
use App\Modules\Auth\Models\User;
use Illuminate\Contracts\Support\Renderable;

final class MiscController extends Controller
{
    public function __construct(private readonly RankingCalculatorInterface $calculator)
    {
    }

    public function albo(): Renderable
    {
        return view('misc.albo');
    }

    public function statistics(User $user): Renderable
    {
        $rank = $this->calculator->get()->where(static fn ($item) => $item->user()->id === $user->id)->map(
            static function ($item, $key) {
                return [
                    'userPosition' => $key,
                    'userRank' => $item,
                ];
            }
        )->first();

        return view(
            'statistics.show',
            array_merge(
                [
                    'userBets' => $user->bets->sortByDesc(static fn ($bet) => $bet->game->game_date)->values(),
                ],
                $rank
            )
        );
    }
}
