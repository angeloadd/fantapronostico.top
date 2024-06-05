<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\Ranking\RankingCalculator;
use Illuminate\View\View;

final class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // classifica completa
    public function officialStanding(): View
    {
        $standing = (new RankingCalculator())->get();

        return view('bet.standing', compact('standing'));
    }
}
