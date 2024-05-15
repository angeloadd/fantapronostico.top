<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Contracts\VerifyEmailResponse;
use Laravel\Fortify\Http\Requests\VerifyEmailRequest;

final class VerifyEmailAction extends Controller
{
    public function __invoke(VerifyEmailRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return app(VerifyEmailResponse::class);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('home'));
    }
}
