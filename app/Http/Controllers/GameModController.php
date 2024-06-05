<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Champion;
use App\Models\Game;
use App\Models\Player;
use App\Modules\Tournament\Models\Team;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

final class GameModController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('mod');
    }

    public function index(): Renderable
    {
        return view('mod.gamesIndex', ['games' => Game::all()]);
    }

    public function gameEdit(Game $game): Renderable
    {
        $home_team = $game->home;
        $away_team = $game->away;

        return isset($home_team, $away_team)
            ? view('mod.gameEdit', compact('game', 'home_team', 'away_team'))
            : view('mod.setGame', compact('game'));
    }

    public function setGame(Game $game, Request $request)
    {
        $game->update([
            'home_team' => htmlentities($request->home_team, ENT_QUOTES, 'UTF-8'),
            'away_team' => htmlentities($request->away_team, ENT_QUOTES, 'UTF-8'),
        ]);

        return redirect(route('mod.gameEdit', compact('game')))->with('message', 'squadre inserite');
    }

    public function gameUpdate(Game $game, Request $request)
    {
        $homeScore = [];
        if ($request->home_result > 0) {
            for ($i = 1; $i <= $request->home_result; $i++) {
                $homeScore[] = 'AutoGol' === $request['homeScore' . $i] ? 1000000001 : (int) $request['homeScore' . $i];
            }
        } else {
            $homeScore[] = 1000000000;
        }

        $awayScore = [];
        if ($request->away_result > 0) {
            for ($i = 1; $i <= $request->away_result; $i++) {
                $awayScore[] = 'AutoGol' === $request['awayScore' . $i] ? 1000000001 : (int) $request['awayScore' . $i];
            }
        } else {
            $awayScore[] = 1000000000;
        }

        if ($request->home_result > $request->away_result) {
            $sign = '1';
        } elseif ($request->home_result < $request->away_result) {
            $sign = '2';
        } else {
            $sign = 'X';
        }

        $game->update([
            'home_result' => htmlentities($request->home_result, ENT_QUOTES, 'UTF-8'),
            'away_result' => htmlentities($request->away_result, ENT_QUOTES, 'UTF-8'),
            'home_score' => $homeScore,
            'away_score' => $awayScore,
            'sign' => $sign,
        ]);

        Cache::forget('usersRank');

        return redirect(route('mod.gamesIndex'))->with('message', 'La partita è stata aggiornata con successo');
    }

    public function editWinner()
    {
        $champion = Champion::find(1);

        return view('mod.editWinner', compact('champion'));
    }

    public function updateWinner(Request $request)
    {
        $top_scorers = [];
        for ($i = 1; $i <= $request->number_of_scorers; $i++) {
            $top_scorers[] = $request['top_scorer' . $i];
        }

        Team::where('name', $request->champion_team)
            ->first()
            ?->update([
                'winner' => true,
            ]);

        foreach ($top_scorers as $topScorer) {
            Player::find($topScorer)
                ?->update([
                    'top_scorer' => true,
                ]);
        }

        return redirect(route('mod.editWinner'))->with('message', 'successo');
    }
}
