<?php

declare(strict_types=1);

use App\Http\Controllers\ChampionController;
use App\Http\Controllers\GameModController;
use App\Http\Controllers\GameNotAccessibleAction;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\ModController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserModController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([], static function (Router $r): void {
    $routesFromModules = glob(__DIR__ . '/../app/Modules/*/Http/Routes/*.php');
    if ( ! $routesFromModules) {
        $routesFromModules = [];
    }
    foreach ($routesFromModules as $moduleRoutesPath) {
        require $moduleRoutesPath;
    }
});

/* homepage */
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/game/not/accessible/{game?}', GameNotAccessibleAction::class)->name('errors.gameNotAccessible');

/* Bet CRUD */
Route::get('/prossimo/incontro/{game}', [PredictionController::class, 'nextGameFromReference'])->name('bet.nextFromReference');
Route::get('/precedente/incontro/{game}', [PredictionController::class, 'previousGameFromReference'])->name('bet.previousFromReference');
Route::get('/pronostico/prossimo/incontro', [PredictionController::class, 'nextGame'])->name('bet.nextGame');
Route::get('/pronostici/incontro/{game}', [PredictionController::class, 'index'])->name('bet.index');
Route::get('/pronostico/incontro/{game}', [PredictionController::class, 'show'])->name('bet.show');
Route::get('/pronostico/incontro/{game}/crea', [PredictionController::class, 'create'])->name('bet.create');
Route::post('/pronostico/incontro/{game}/store', [PredictionController::class, 'store'])->name('bet.store');
Route::get('/pronostico/modifica/{bet}', [PredictionController::class, 'edit'])->name('bet.edit');
Route::put('/pronostico/aggiorna/{bet}', [PredictionController::class, 'update'])->name('bet.update');

/* CRUD per vincitore e capocannoniere */
Route::get('/pronostico/vincitore/index', [ChampionController::class, 'index'])->name('champion.index');
Route::get('/pronostico/vincitore/create', [ChampionController::class, 'create'])->name('champion.create');
Route::post('/pronostico/vincitore/store', [ChampionController::class, 'store'])->name('champion.store');
Route::get('/pronostico/vincitore/edit/{champion}', [ChampionController::class, 'edit'])->name('champion.edit');
Route::post('/pronostico/vincitore/update/{champion}', [ChampionController::class, 'update'])->name('champion.update');
Route::get('/pronostico/vincitore/show/{champion}', [ChampionController::class, 'show'])->name('champion.show');
Route::get('/pronostico/vincitore/error', [ChampionController::class, 'error'])->name('champion.error');

/* rotte per moderatori */
Route::get('pannello/controllo', [ModController::class, 'index'])->name('mod.index');

//gestione degli users
Route::get('pannello/controllo/utenti', [UserModController::class, 'index'])->name('mod.usersIndex');
Route::get('pannello/controllo/crea/utente', [UserModController::class, 'create'])->name('mod.userCreate');
Route::post('pannello/controllo/nuovo/utente/creato', [UserModController::class, 'modUserStore'])
    ->name('mod.userStore');
Route::get('pannello/controllo/utenti/{user}', [UserModController::class, 'modUserEdit'])->name('mod.userEdit');
Route::put('pannello/controllo/utenti/modifica/{user}/', [UserModController::class, 'modUserUpdate'])
    ->name('mod.userUpdate');
Route::delete('pannello/controllo/cancella/{user}', [UserModController::class, 'modUserDelete'])
    ->name('mod.userDelete');

// gestione partite
Route::get('pannello/controllo/partite', [GameModController::class, 'index'])->name('mod.gamesIndex');
Route::get('pannello/controllo/modifica/partita/{game}', [GameModController::class, 'gameEdit'])->name('mod.gameEdit');
Route::put('pannello/controllo/aggiorna/partita/{game}', [GameModController::class, 'gameUpdate'])->name(
    'mod.gameUpdate'
);
Route::put('pannello/controllo/inserisci/squadre/{game}', [GameModController::class, 'setGame'])->name('mod.setGame');

//gestione vincitore
Route::get('pannello/controllo/vincitore', [GameModController::class, 'editWinner'])->name('mod.editWinner');
Route::put('pannello/controllo/vincitore/modifica', [GameModController::class, 'updateWinner'])->name(
    'mod.updateWinner'
);

// classifica
Route::get('classifica', [UserController::class, 'officialStanding'])->name('standing');

Route::get('albo', [MiscController::class, 'albo'])->name('albo');
Route::get('statistiche/{user}', [MiscController::class, 'statistics'])->name('statistics')->middleware(['auth']);
