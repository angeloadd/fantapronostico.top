<?php

declare(strict_types=1);

use App\Modules\Auth\Http\Controllers\AuthViewController;
use App\Modules\Auth\Http\Controllers\LoginAction;
use App\Modules\Auth\Http\Controllers\LogoutAction;
use App\Modules\Auth\Http\Controllers\RegisterAction;
use Illuminate\Routing\Router;

/** @var Router $r */
$r->middleware('guest')
    ->group(static function (Router $r): void {
        $r->as('api.')->group(static fn () => [
            $r->post('/login', LoginAction::class)->name('login'),
            $r->post('/register', RegisterAction::class)->name('register'),
        ]);
        $r->get('/login', AuthViewController::class)->name('login');
        $r->get('/register', AuthViewController::class)->name('register');
    });

$r->middleware('auth')
    ->group(static function (Router $r): void {
        $r->as('api.')->delete('/logout', LogoutAction::class)->name('logout');
        //TODO: e2e and middleware
        $r->get('/verify-email', AuthViewController::class)->name('verify-email');
    });
