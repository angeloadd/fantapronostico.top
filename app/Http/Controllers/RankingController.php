<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\Ranking\RankingCalculatorInterface;
use App\Helpers\Ranking\UserRank;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

final class RankingController extends Controller
{
    public function __construct(private readonly RankingCalculatorInterface $calculator)
    {
        $this->middleware('auth');
    }

    // classifica completa
    public function officialStanding(Request $request): View
    {
        return view('pages.ranking.index', [
            'ranking' => $this->calculator->get($request->input('league')),
        ]);
    }

    public function rank(Request $request): Response
    {
        return new Response(
            view('pages.ranking.shared.table', [
                'ranking'=> $this->calculator->get($request->input('league'))
                    ->filter(static fn (UserRank $rank, int $index) => Auth::user()?->id === $rank->userId() || $index <= 12),
                'isHome' => true
            ])->render()
        );
    }
}
