<?php

declare(strict_types=1);

use App\Http\Controllers\ChampionController;
use App\Http\Controllers\GameNotAccessibleAction;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LeagueEnricherMiddleware;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
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

Route::middleware(['auth', LeagueEnricherMiddleware::class])->group(static function (): void {
    /* homepage */
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/game/not/accessible/{game?}', GameNotAccessibleAction::class)->name('errors.gameNotAccessible');

    Route::middleware([EnsureEmailIsVerified::class])->group(static function (): void {
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
    });

    // classifica
    Route::get('classifica', [UserController::class, 'officialStanding'])->name('standing');

    Route::get('albo', [MiscController::class, 'albo'])->name('albo');
    Route::get('terms', [MiscController::class, 'terms'])->name('terms');
    //Route::get('statistiche/{user}', [MiscController::class, 'statistics'])->name('statistics')->middleware(['auth']);
});
