<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pipeline\Pipeline;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;

final readonly class LoginApiAction
{
    public function __construct(
        private StatefulGuard $auth,
        private Pipeline $pipeline
    ) {
    }

    public function __invoke(LoginRequest $request): mixed
    {
        $request->merge([
            'remember' => true,
            'email' => $request->email(),
        ]);

        return $this->pipeline->send($request)->through([
            EnsureLoginIsNotThrottled::class,
            AttemptToAuthenticate::class,
            PrepareAuthenticatedSession::class,
        ])->then(function (): RedirectResponse {
            if ($this->auth->user() instanceof User && null === $this->auth->user()->email_verified_at) {
                return new RedirectResponse(route('verify-email'));
            }

            return new RedirectResponse(route('home'));
        });
    }
}
