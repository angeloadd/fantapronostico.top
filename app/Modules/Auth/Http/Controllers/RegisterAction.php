<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Controllers;

use App\Modules\Auth\Http\Requests\RegisterRequest;
use App\Modules\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
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

        event(new Registered($user));

        $user->sendEmailVerificationNotification();

        $this->auth->login($user, true);

        return redirect(route('verify-email'));
    }
}
