<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreatePredictionRequest;
use App\Models\Game;
use App\Models\Player;
use App\Models\Prediction;
use App\Modules\Tournament\Models\Team;
use App\Repository\Game\GameRepositoryInterface;
use App\Repository\Prediction\PredictionRepositoryInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

final class PredictionController extends Controller
{
    public function __construct(
        private readonly PredictionRepositoryInterface $betRepository,
        private readonly GameRepositoryInterface $gameRepository,
    ) {
        $this->middleware(['auth']);
    }

    public function nextGame(): Renderable|RedirectResponse
    {
        $nextGame = $this->gameRepository->getNextGame() ?? Game::all()->last();
        if (null !== $nextGame) {
            return redirect(route('prediction.index', ['game' => $nextGame]))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        return abort(404);
    }

    public function index(Game $game): Renderable|RedirectResponse
    {
        if ($game->started_at->isPast()) {
            return view(
                'pages.prediction.index',
                [
                    'sortedBets' => $this->betRepository->getSortedDescByUpdatedAtByGame($game),
                    'games' => $this->gameRepository->getAll(),
                ],
                compact('game')
            );
        }

        return redirect(route('prediction.show', compact('game')))
            ->with('message', session('message') ?: null)
            ->with('errore_message', session('error_message') ?: null);
    }

    public function show(Game $game): Renderable|RedirectResponse
    {
        if ($game->started_at->isPast()) {
            return redirect(route('prediction.index', compact('game')))
                ->with('error_message', 'La partita è iniziata');
        }

        if ($game->isNotPredictableYet()) {
            return redirect(route('errors.gameNotAccessible', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        //Controllo per presenza pronostico da mostrare
        $prediction = $this->betRepository->getByGameAndUser($game, Auth::user());
        if (null === $prediction) {
            return redirect(route('prediction.create', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        if (0 === $prediction->home_scorer_id) {
            $homeScorer = 'NoGol';
        } elseif (-1 === $prediction->home_scorer_id) {
            $homeScorer = 'Autogol';
        } else {
            $homeScorer = Player::where('id', $prediction->home_scorer_id)->first()?->displayed_name;
        }
        if (0 === $prediction->away_scorer_id) {
            $awayScorer = 'NoGol';
        } elseif (-1 === $prediction->away_scorer_id) {
            $awayScorer = 'Autogol';
        } else {
            $awayScorer = Player::where('id', $prediction->away_scorer_id)->first()?->displayed_name;
        }

        return view('pages.prediction.show', [
            'games' => $this->gameRepository->getAll(),
            'game' => $game,
            'prediction' => $prediction,
            'homeScorer' => $homeScorer ?? 0,
            'awayScorer' => $awayScorer ?? 0,
        ]);
    }

    public function create(Game $game): Renderable|RedirectResponse
    {
        // controllo per display pronostici con sort per ordinarli
        if ($game->started_at->isPast()) {
            return redirect(route('prediction.index', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        if ( ! $this->gameRepository->areGameTeamsSet($game)) {
            return abort(404);
        }

        //        Controllo per non anticipare troppo i pronostici
        if ($game->isNotPredictableYet()) {
            return redirect(route('errors.gameNotAccessible', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        if ($this->betRepository->existsByGameAndUser($game, Auth::user())) {
            return redirect(route('prediction.show', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        return view(
            'pages.prediction.create',
            compact('game'),
            [
                'games' => $this->gameRepository->getAll(),
                'homeTeamPlayers' => $this->getTeamScorersList($game->home_team),
                'awayTeamPlayers' => $this->getTeamScorersList($game->away_team),
            ]
        );
    }

    public function store(CreatePredictionRequest $request, Game $game): RedirectResponse
    {
        //         Controllo per limite di tempo
        if ($game->started_at->isPast()) {
            return redirect(route('prediction.index', compact('game')))
                ->with('error_message', 'Hai superato il limite di tempo!');
        }

        if ( ! $this->gameRepository->areGameTeamsSet($game)) {
            abort(404);
        }

        if ($game->isNotPredictableYet()) {
            return redirect(route('errors.gameNotAccessible', compact('game')))
                ->with('error_message', 'L\'incontro non è ancora accessibile');
        }

        if ($this->betRepository->existsByGameAndUser($game, Auth::user())) {
            return redirect(route('prediction.show', compact('game')))
                ->with('error_message', 'Hai già pronosticato per questo incontro');
        }

        // validazione
        $game->predictions()->create([
            'home_score' => $request->home_score,
            'away_score' => $request->away_score,
            'sign' => $request->sign,
            'home_scorer_id' => $request->home_scorer_id,
            'away_scorer_id' => $request->away_scorer_id,
            'user_id' => auth()->user()->id,
        ]);

        return back()->with('message', 'Pronostico inserito con successo');
    }

    public function edit(Prediction $prediction): RedirectResponse|Renderable
    {
        // controllo per accesso a pronostici diversi dal proprio
        if (Auth::user()->id !== $prediction->user_id) {
            return abort(404);
        }

        $game = $prediction->game;

        //Controllo per modifica oltre tempo limite
        if ($game->started_at->isPast()) {
            return redirect(route('prediction.index', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        if ( ! $this->gameRepository->areGameTeamsSet($game)) {
            return abort(404);
        }

        //Controllo per non anticipare troppo i pronostici
        if ($game->isNotPredictableYet()) {
            return redirect(route('errors.gameNotAccessible', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        // Controllo per view edit
        return view(
            'pages.prediction.edit',
            compact('prediction', 'game'),
            [
                'homeTeamPlayers' => $this->getTeamScorersList($game->home_team),
                'awayTeamPlayers' => $this->getTeamScorersList($game->away_team),
            ]
        );
    }

    public function update(CreatePredictionRequest $request, Prediction $prediction): RedirectResponse
    {
        // controllo per accesso a pronostici diversi dal proprio
        if (Auth::user()->id !== $prediction->user_id) {
            return abort(404);
        }

        $game = $prediction->game;

        // Controllo per caricamento pronostico oltre il limite
        if ($game->started_at->isPast()) {
            return redirect(route('prediction.index', compact('game')))
                ->with('error_message', 'Hai superato il limite di tempo!');
        }

        if ( ! $this->gameRepository->areGameTeamsSet($game)) {
            return abort(404);
        }

        if ($game->isNotPredictableYet()) {
            return redirect(route('errors.gameNotAccessible', compact('game')))
                ->with('error_message', 'L\'incontro non è ancora accessibile');
        }

        $prediction->update([
            'home_score' => $request->home_score,
            'away_score' => $request->away_score,
            'sign' => $request->sign,
            'home_scorer_id' => $request->home_scorer_id,
            'away_scorer_id' => $request->away_scorer_id,
            'user_id' => Auth::user()->id,
        ]);

        return redirect(route('prediction.index', compact('game')))
            ->with('message', 'Pronostico modificato con successo');
    }

    public function nextGameFromReference(Game $game): RedirectResponse
    {
        $goToGame = $this->gameRepository->getNextGameByOtherGame($game) ?? $game;

        if ( ! $this->gameRepository->areGameTeamsSet($goToGame)) {
            return abort(404);
        }

        return redirect(route('prediction.index', ['game' => $goToGame]));
    }

    public function previousGameFromReference(Game $game): RedirectResponse
    {
        $goToGame = $this->gameRepository->getPreviousGameByOtherGame($game) ?? $game;

        if ( ! $this->gameRepository->areGameTeamsSet($goToGame)) {
            return abort(404);
        }

        return redirect(route('prediction.index', ['game' => $goToGame]));
    }

    public function getTeamScorersList(Team $team): Collection
    {
        $players = $team->players
            ->pluck('displayed_name', 'id');
        $players[0] = 'NoGol';
        $players[-1] = 'Autogol';

        return $players->sortKeys();
    }
}
