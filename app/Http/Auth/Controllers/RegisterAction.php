<?php

declare(strict_types=1);

namespace App\Http\Auth\Controllers;

use App\Http\Auth\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

final readonly class RegisterAction
{
    public function __construct(
        private StatefulGuard $auth
    ) {
    }

    public function __invoke(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            RegisterRequest::NAME => $request->name(),
            RegisterRequest::EMAIL => $request->email(),
            RegisterRequest::PASSWORD => Hash::make($request->password()),
        ]);

        $user->sendEmailVerificationNotification();

        $this->auth->login($user, true);

        if ($this->auth->user() instanceof User && null === $this->auth->user()->email_verified_at) {
            return new RedirectResponse(route('verify-email'));
        }

        return new RedirectResponse(route('home'));
    }
}
