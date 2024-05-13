<?php

declare(strict_types=1);

use App\Modules\Auth\Http\Controllers\AuthViewsController;
use App\Modules\Auth\Http\Controllers\LoginAction;
use App\Modules\Auth\Http\Controllers\LogoutAction;
use App\Modules\Auth\Http\Controllers\RegisterAction;
use App\Modules\Auth\Http\Controllers\SendVerificationLinkEmailAction;
use App\Modules\Auth\Http\Controllers\VerifyEmailAction;
use Illuminate\Routing\Router;

/** @var Router $r */
$r->middleware('guest')
    ->group(static function (Router $r): void {
        $r->as('api.')->group(static fn () => [
            $r->post('/login', LoginAction::class)->name('login'),
            $r->post('/register', RegisterAction::class)->name('register'),
        ]);
        $r->get('/login', AuthViewsController::class)->name('login');
        $r->get('/register', AuthViewsController::class)->name('register');
    });

$r->middleware('auth')
    ->group(static function (Router $r): void {
        $r->as('api.')->delete('/logout', LogoutAction::class)->name('logout');
        //TODO: e2e
        $r->get('/verify-email', [AuthViewsController::class, 'verifyEmail'])
            ->name('verify-email');
        $r->get('/email/verified/{id}/{hash}', VerifyEmailAction::class)
            ->middleware(['signed', 'throttle:5,1'])
            ->name('email.verified');
        $r->post('/email/verify/notification', SendVerificationLinkEmailAction::class)
            ->middleware('throttle:2,15')
            ->name('api.notification');
    });
