<?php

declare(strict_types=1);

use App\Http\Auth\Controllers\AuthViewController;
use App\Http\Auth\Controllers\LoginAction;
use App\Http\Auth\Controllers\LogoutAction;
use App\Http\Auth\Controllers\RegisterAction;
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
        $r->post('/api_login', LoginAction::class)
            ->name('api_login');
        $r->post('/api_register', RegisterAction::class)
            ->name('api_register');
        foreach (['login', 'register'] as $route) {
            $r->get($route, AuthViewController::class)
                ->name($route);
        }
    });

Route::middleware('auth')
    ->group(static function (Router $r): void {
        $r->delete('/logout_api', LogoutAction::class)
            ->name('logout_api');
        //TODO: e2e and middleware
        $r->get('/verify-email', AuthViewController::class)
            ->name('verify-email');
    });
