<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\BetRequest;
use App\Models\Game;
use App\Models\Player;
use App\Models\Prediction;
use App\Repository\Game\GameRepositoryInterface;
use App\Repository\Prediction\PredictionRepositoryInterface;
use App\Service\TimeManagementServiceInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

final class BetController extends Controller
{
    public function __construct(
        private readonly TimeManagementServiceInterface $timeManagementService,
        private readonly PredictionRepositoryInterface $betRepository,
        private readonly GameRepositoryInterface $gameRepository,
    ) {
        $this->middleware(['auth']);
    }

    public function nextGame(): Renderable|RedirectResponse
    {
        $now = $this->timeManagementService->now();
        if ($this->gameRepository->nextGameExists($now)) {
            return redirect(route('bet.index', ['game' => $this->gameRepository->getNextGameByDateTime($now)]))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        $last = Game::all()->last();
        if ( ! $last) {
            return redirect(route('errors.gameNotSet'))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        return redirect(route('bet.index', ['game' => $last]))
            ->with('message', session('message') ?: null)
            ->with('errore_message', session('error_message') ?: null);
    }

    public function index(Game $game): Renderable|RedirectResponse
    {
        if ($this->timeManagementService->isGameInThePast($game->started_at)) {
            return view(
                'bet.index',
                [
                    'sortedBets' => $this->betRepository->getSortedDescByUpdatedAtByGame($game),
                    'games' => $this->gameRepository->getAll(),
                ],
                compact('game')
            );
        }

        return redirect(route('bet.show', compact('game')))
            ->with('message', session('message') ?: null)
            ->with('errore_message', session('error_message') ?: null);
    }

    public function show(Game $game): Renderable|RedirectResponse
    {
        if ($this->timeManagementService->isGameInThePast($game->started_at)) {
            return redirect(route('bet.index', compact('game')))
                ->with('error_message', 'La partita è iniziata');
        }

        if ($this->timeManagementService->isGameNotPredictableYet($game->started_at)) {
            return redirect(route('errors.gameNotAccessible', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        //Controllo per presenza pronostico da mostrare
        if ( ! $this->betRepository->existsByGameAndUser($game, Auth::user())) {
            return redirect(route('bet.create', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        $prediction = $this->betRepository->getByGameAndUser($game, Auth::user());

        if (0 === $prediction->home_scorer_id) {
            $homeScorer = 'NoGol';
        } elseif (-1 === $prediction->home_scorer_id) {
            $homeScorer = 'Autogol';
        } else {
            $homeScorer = Player::where('id', $prediction->home_scorer_id)->first()->displayed_name;
        }
        if (0 === $prediction->away_scorer_id) {
            $awayScorer = 'NoGol';
        } elseif (-1 === $prediction->away_scorer_id) {
            $awayScorer = 'Autogol';
        } else {
            $awayScorer = Player::where('id', $prediction->away_scorer_id)->first()->displayed_name;
        }

        return view('bet.show', [
            'games' => $this->gameRepository->getAll(),
            'game' => $game,
            'userBet' => $prediction,
            'updatedAtMillis' => $prediction->updated_at->format('u'),
            'updatedAtTime' => $prediction->updated_at->format('H:i:s'),
            'updatedAt' => $prediction->updated_at->format('d/m/Y'),
            'homeScorer' => $homeScorer ?? 0,
            'awayScorer' => $awayScorer ?? 0,
        ]);
    }

    public function create(Game $game): Renderable|RedirectResponse
    {
        // controllo per display pronostici con sort per ordinarli
        if ($this->timeManagementService->isGameInThePast($game->started_at)) {
            return redirect(route('bet.index', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        if ( ! $this->gameRepository->areGameTeamsSet($game)) {
            return redirect(route('errors.gameNotSet'))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        //Controllo per non anticipare troppo i pronostici
        if ($this->timeManagementService->isGameNotPredictableYet($game->started_at)) {
            return redirect(route('errors.gameNotAccessible', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        if ($this->betRepository->existsByGameAndUser($game, Auth::user())) {
            return redirect(route('bet.show', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        return view(
            'bet.create',
            compact('game'),
            ['games' => $this->gameRepository->getAll()]
        );
    }

    public function store(BetRequest $request, Game $game): RedirectResponse
    {
        // Controllo per limite di tempo
        if ($this->timeManagementService->isGameInThePast($game->started_at)) {
            return redirect(route('bet.index', compact('game')))
                ->with('error_message', 'Hai superato il limite di tempo!');
        }

        if ( ! $this->gameRepository->areGameTeamsSet($game)) {
            return redirect(route('errors.gameNotSet'))
                ->with('error_message', 'L\'incontro non è ancora accessibile');
        }

        if ($this->timeManagementService->isGameNotPredictableYet($game->started_at)) {
            return redirect(route('errors.gameNotAccessible', compact('game')))
                ->with('error_message', 'L\'incontro non è ancora accessibile');
        }

        if ($this->betRepository->existsByGameAndUser($game, Auth::user())) {
            return redirect(route('bet.show', compact('game')))
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

    public function edit(Prediction $bet): RedirectResponse|Renderable
    {
        // controllo per accesso a pronostici diversi dal proprio
        if (Auth::user()->id !== $bet->user_id) {
            return abort(404);
        }

        $game = $bet->game;

        //Controllo per modifica oltre tempo limite
        if ($this->timeManagementService->isGameInThePast($game->started_at)) {
            return redirect(route('bet.index', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        if ( ! $this->gameRepository->areGameTeamsSet($game)) {
            return redirect(route('errors.gameNotSet'))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        //Controllo per non anticipare troppo i pronostici
        if ($this->timeManagementService->isGameNotPredictableYet($game->started_at)) {
            return redirect(route('errors.gameNotAccessible', compact('game')))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        // Controllo per view edit
        return view('bet.edit', compact('bet', 'game'));
    }

    public function update(BetRequest $request, Prediction $bet): RedirectResponse
    {
        // controllo per accesso a pronostici diversi dal proprio
        if (Auth::user()->id !== $bet->user_id) {
            return abort(404);
        }

        $game = $bet->game;

        // Controllo per caricamento pronostico oltre il limite
        if ($this->timeManagementService->isGameInThePast($game->started_at)) {
            return redirect(route('bet.index', compact('game')))
                ->with('error_message', 'Hai superato il limite di tempo!');
        }

        if ( ! $this->gameRepository->areGameTeamsSet($game)) {
            return redirect(route('errors.gameNotSet'))
                ->with('error_message', 'L\'incontro non è ancora accessibile');
        }

        if ($this->timeManagementService->isGameNotPredictableYet($game->started_at)) {
            return redirect(route('errors.gameNotAccessible', compact('game')))
                ->with('error_message', 'L\'incontro non è ancora accessibile');
        }

        $bet->update([
            'home_score' => $request->home_score,
            'away_score' => $request->away_score,
            'sign' => $request->sign,
            'home_scorer_id' => $request->home_scorer_id,
            'away_scorer_id' => $request->away_scorer_id,
            'user_id' => Auth::user()->id,
        ]);

        return redirect(route('bet.index', compact('game')))
            ->with('message', 'Pronostico modificato con successo');
    }

    public function nextGameFromReference(Game $game): RedirectResponse
    {
        $goToGame = $this->gameRepository->getNextGameByOtherGame($game) ?? $game;

        if ( ! $this->gameRepository->areGameTeamsSet($goToGame)) {
            return redirect(route('errors.gameNotSet'))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        return redirect(route('bet.index', ['game' => $goToGame]));
    }

    public function previousGameFromReference(Game $game): RedirectResponse
    {
        $goToGame = $this->gameRepository->getPreviousGameByOtherGame($game) ?? $game;

        if ( ! $this->gameRepository->areGameTeamsSet($goToGame)) {
            return redirect(route('errors.gameNotSet'))
                ->with('message', session('message') ?: null)
                ->with('errore_message', session('error_message') ?: null);
        }

        return redirect(route('bet.index', ['game' => $goToGame]));
    }
}
