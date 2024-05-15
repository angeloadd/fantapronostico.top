<?php

declare(strict_types=1);

use App\Modules\Auth\Http\Controllers\SendPasswordResetLinkEmailAction;
use App\Modules\Auth\Http\Controllers\SendVerificationLinkEmailAction;
use Illuminate\Routing\Router;

/** @var Router $r */
$r->middleware('auth')
    ->group(static function (Router $r): void {
        $r->post('send-email-verification-link', SendVerificationLinkEmailAction::class)->name('send-email-verification-link');
    });
$r->middleware('guest')
    ->group(static function (Router $r): void {
        $r->post('send-password-reset-link', SendPasswordResetLinkEmailAction::class)->name('send-password-reset-link');
    });
