<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Modules\Auth\Enums\RoleEnum;
use App\Modules\Auth\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $some = Auth::user()?->roles->some(static fn(Role $role) => $role->role === RoleEnum::ADMIN);
        if ($some) {
            return $next($request);
        }

        return redirect(route('home'));

    }
}
