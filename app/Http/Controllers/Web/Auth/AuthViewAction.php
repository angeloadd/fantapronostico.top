<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class AuthViewAction
{
    public function __invoke(Request $request): Response|RedirectResponse
    {
        if('verify-email' === $request->route()?->getName() && Auth::user() && null !== Auth::user()->email_verified_at){
            return redirect(route('home'));
        }
        return new Response(
            view(
                'pages.auth.auth',
                ['type' => ltrim($request->getPathInfo(), '/')]
            )->render(),
            200
        );
    }
}
