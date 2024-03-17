<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Controllers;

use App\Modules\Auth\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class AuthViewController
{
    public function __invoke(Request $request): Response|RedirectResponse
    {
        /** @var ?User $user */
        $user = Auth::user();
        if ('verify-email' === $request->route()?->getName() && $user && null !== $user->email_verified_at) {
            return redirect(route('home'));
        }

        return new Response(
            view(
                'auth::main',
                ['pageName' => ltrim($request->getPathInfo(), '/')]
            )->render(),
            200
        );
    }
}
