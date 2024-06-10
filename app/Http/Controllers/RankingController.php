<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\Ranking\RankingCalculatorInterface;
use Illuminate\View\View;

final class RankingController extends Controller
{
    public function __construct(private readonly RankingCalculatorInterface $calculator)
    {
        $this->middleware('auth');
    }

    // classifica completa
    public function officialStanding(): View
    {
        return view('pages.ranking.index', [
            'ranking' => $this->calculator->get(),
        ]);
    }
}
