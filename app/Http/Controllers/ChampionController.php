<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Http\Requests\ChampionRequest;
use App\Models\Champion;
use App\Models\Player;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

final class ChampionController extends Controller
{
    public const ONE_HOUR_IN_SECONDS = 60 * 60;

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function create(): Renderable|RedirectResponse
    {
        if ($this->isChampionBetAvailableByDate()) {
            return redirect(route('champion.error'))->with('La competizione non è ancora iniziata');
        }

        if ($this->competitionStarted()) {
            return redirect(route('champion.index'));
        }

        $champion = Auth::user()->champion;
        if ($champion) {
            return redirect(route('champion.show', compact('champion')));
        }

        return view(
            'champion.create',
            [
                'teams' => Team::all(),
                'players' => Player::getInfoForAll(),
            ]
        );
    }

    public function store(ChampionRequest $request): RedirectResponse
    {
        if ($this->competitionStarted()) {
            return redirect(route('champion.index'))
                ->with(
                    'error_message',
                    'La competizione è già iniziata, non puoi più inserire o modificare un pronostico'
                );
        }

        $champion = Auth::user()->champion;
        if ($champion) {
            return redirect(route('champion.show'), compact('champion'));
        }

        $champion = Auth::user()?->champion()->create([
            'team_id' => $request->input('winner'),
            'player_id' => $request->input('topScorer'),
        ]);

        return redirect(route('champion.show', compact('champion')))
            ->with('message', 'Pronostico inserito con successo');
    }

    public function edit(Champion $champion): RedirectResponse|Renderable
    {
        if ($this->competitionStarted()) {
            return redirect(route('champion.index'))->with('error_message', 'La competizione è già iniziata');
        }

        if (Auth::user()?->id !== $champion->user_id) {
            return abort(404, 'Not Found');
        }

        return view(
            'champion.edit',
            [
                'teams' => Team::all(),
                'players' => Player::getInfoForAll(),
                'champion' => $champion,
            ]
        );
    }

    public function update(ChampionRequest $request, Champion $champion): RedirectResponse
    {
        if ($this->competitionStarted()) {
            return redirect(route('champion.index'))
                ->with(
                    'error_message',
                    'La competizione è già iniziata, non puoi più inserire o modificare un pronostico'
                );
        }

        if (Auth::user()?->id !== $champion->user_id) {
            return abort(404, 'Not found');
        }

        $champion->update([
            'team_id' => $request->input('winner'),
            'player_id' => $request->input('topScorer'),
        ]);

        return redirect(route('champion.show', compact('champion')))
            ->with('message', 'pronostico aggiornato con successo');
    }

    public function show(Champion $champion): Renderable|RedirectResponse
    {
        if ($this->competitionStarted()) {
            return redirect(route('champion.index'))->with('error_message', 'La competizione è iniziata');
        }

        if (Auth::user()?->id !== $champion->user_id) {
            return abort(404, 'Not Found');
        }

        return view(
            'champion.show',
            compact('champion')
        );
    }

    public function index(): Renderable
    {
        if ( ! $this->competitionStarted()) {
            return abort(404, 'not found');
        }

        return view(
            'champion.index',
            [
                'champion' => Champion::all(),
            ]
        );
    }

    public function error(): Renderable
    {
        return view('champion.error', ['championSettableFrom' => $this->getChampionSettableFrom()]);
    }

    private function getChampionSettableFrom(): Carbon
    {
        return Carbon::create('17-11-2022 21:00')->timezone('Europe/Rome');
    }

    private function isChampionBetAvailableByDate(): bool
    {
        return time() <= $this->getChampionSettableFrom()->unix();
    }

    private function competitionStarted(): bool
    {
        return now()->unix() >= (Constants::FIRST_GAME_SART_TIMESTAMP - self::ONE_HOUR_IN_SECONDS);
    }
}