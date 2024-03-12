<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Auth;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final readonly class LogoutApiAction
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

        return new RedirectResponse(route('home'));
    }
}
