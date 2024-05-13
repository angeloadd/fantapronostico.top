<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Controllers;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final readonly class LogoutAction
{
    public function __construct(private StatefulGuard $auth)
    {
    }

    public function __invoke(Request $request): RedirectResponse
    {
        $this->auth->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        event(Logout::class);

        return new RedirectResponse(route('home'));
    }
}
