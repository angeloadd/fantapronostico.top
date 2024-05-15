<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class AuthViewsController
{
    public function __invoke(Request $request): Response
    {
        return $this->makeResponse(ltrim($request->getPathInfo(), '/'));
    }

    public function verifyEmail(Request $request): Response|RedirectResponse
    {
        return $request->user()->hasVerifiedEmail() ?
            redirect()->intended(route('home')) :
            $this->makeResponse('verify-email');
    }

    public function makeResponse(string $routeName): Response
    {
        return new Response(
            view(
                'auth::index',
                ['pageName' => $routeName]
            )->render(),
            200
        );
    }
}
