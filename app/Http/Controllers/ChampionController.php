<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ChampionRequest;
use App\Models\Champion;
use App\Models\Game;
use App\Models\Player;
use App\Modules\Tournament\Models\Team;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

final class ChampionController extends Controller
{
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
                'firstMatchDate' => $this->getFirstMatchStartDate(),
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
            abort(404);
        }

        return view(
            'champion.edit',
            [
                'teams' => Team::all(),
                'players' => Player::getInfoForAll(),
                'champion' => $champion,
                'firstMatchDate' => $this->getFirstMatchStartDate(),
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
            abort(404);
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
            abort(404);
        }

        return view(
            'champion.show',
            compact('champion'),
            [
                'firstMatchDate' => $this->getFirstMatchStartDate(),
                'updatedAtMillis' => $champion->updated_at->format('u'),
                'updatedAtTime' => $champion->updated_at->format('H:i:s'),
                'updatedAt' => $champion->updated_at->format('d/m/Y - H:i:s'),
            ]
        );
    }

    public function index(): Renderable
    {
        if ( ! $this->competitionStarted()) {
            abort(404, 'not found');
        }

        return view(
            'champion.index',
            ['champion' => Champion::all()]
        );
    }

    public function error(): Renderable
    {
        return view('champion.error', ['championSettableFrom' => $this->getChampionSettableFrom()]);
    }

    public function getFirstMatchStartDate(): ?Carbon
    {
        return Game::orderBy('started_at', 'asc')?->first()?->started_at;
    }

    private function getChampionSettableFrom(): ?Carbon
    {
        return Carbon::create($this->getFirstMatchStartDate()?->subDays(2))?->timezone('Europe/Rome');
    }

    private function isChampionBetAvailableByDate(): bool
    {
        return time() <= ($this->getChampionSettableFrom()?->unix() ?? 0);
    }

    private function competitionStarted(): bool
    {
        $firstGameStartedAtTimestamp = Game::orderBy('started_at', 'asc')?->first()?->started_at?->unix();

        return now()->unix() >= $firstGameStartedAtTimestamp;
    }
}
