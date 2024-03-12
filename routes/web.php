<?php

declare(strict_types=1);

use App\Http\Controllers\Api\v1\Auth\LoginApiAction;
use App\Http\Controllers\Api\v1\Auth\RegisterApiAction;
use App\Http\Controllers\Web\Auth\AuthViewAction;
use App\Http\Controllers\Web\Auth\LogoutAction;
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

Route::get('/', static fn () => view('pages.home'))->name('home');

Route::middleware('guest')
    ->group(static function (Router $r): void {
        $r->post('/api_login', LoginApiAction::class)
            ->name('api_login');
        $r->post('/api_register', RegisterApiAction::class)
            ->name('api_register')
            ->middleware('throttle:5,60');
        foreach (['login', 'register'] as $route) {
            $r->get($route, AuthViewAction::class)
                ->name($route);
        }
    });

Route::middleware('auth')
    ->group(static function (Router $r): void {
        $r->delete('/logout_api', LogoutAction::class)
            ->name('logout_api');
        //TODO: e2e and middleware
        $r->get('/verify-email', AuthViewAction::class)
            ->name('verify-email');
    });
