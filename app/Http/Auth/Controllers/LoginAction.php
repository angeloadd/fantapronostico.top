<?php

declare(strict_types=1);

namespace App\Http\Auth\Controllers;

use App\Http\Auth\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\LoginRateLimiter;

final readonly class LoginAction
{
    public function __construct(
        private StatefulGuard $auth,
        private UrlGenerator $url,
        private LoginRateLimiter $limiter
    ) {
    }

    public function __invoke(LoginRequest $request): RedirectResponse
    {
        if ($this->limiter->tooManyAttempts($request)) {
            event(new Lockout($request));

            $seconds = $this->limiter->availableIn($request);

            return back()->withErrors(['rate' => trans(
                'auth.throttle',
                [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]
            ),
            ]);
        }

        if ( ! $this->auth->attempt([
            'email' => $request->email(),
            'password' => $request->password(),
        ], true)) {
            $this->limiter->increment($request);

            return back()->withErrors(['email' => [trans('auth.failed')]]);
        }

        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        $this->limiter->clear($request);

        if ($this->auth->user() instanceof User && null === $this->auth->user()->email_verified_at) {
            return new RedirectResponse($this->url->route('verify-email'));
        }

        return new RedirectResponse($this->url->route('home'));
    }
}
