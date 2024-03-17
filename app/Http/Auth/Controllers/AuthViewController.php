<?php

declare(strict_types=1);

namespace App\Http\Auth\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class AuthViewController
{
    public function __invoke(Request $request): Response|RedirectResponse
    {
        if ('verify-email' === $request->route()?->getName() && Auth::user() && null !== Auth::user()->email_verified_at) {
            return redirect(route('home'));
        }

        return new Response(
            view(
                'pages.auth.main',
                ['pageName' => ltrim($request->getPathInfo(), '/')]
            )->render(),
            200
        );
    }
}
