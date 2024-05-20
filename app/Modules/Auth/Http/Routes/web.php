<?php

declare(strict_types=1);

use App\Modules\Auth\Http\Controllers\SendVerificationLinkEmailAction;
use Illuminate\Routing\Router;

/** @var Router $r */
$r->middleware('auth')
    ->group(static function (Router $r): void {
        $r->middleware('throttle:6,1')
            ->post('send-email-verification-link', SendVerificationLinkEmailAction::class)
            ->name('send-email-verification-link');
    });
