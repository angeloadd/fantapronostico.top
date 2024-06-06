<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Modules\Auth\Enums\RoleEnum;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class ModMiddleware
{
    public function handle(Request $request, Closure $next): RedirectResponse|Response
    {
        $user = $request->user();
        if (RoleEnum::MOD === $user->roles->role && $user->roles->league_id === $request->get('league_id')) {
            return $next($request);
        }

        return redirect(route('/'));

    }
}
