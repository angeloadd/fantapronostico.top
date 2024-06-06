<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Modules\Auth\Models\User;
use App\Modules\League\Models\League;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class LeagueEnricherMiddleware
{
    public function handle(Request $request, Closure $next): RedirectResponse|Response
    {
        /** @var User $user */
        $user = $request->user();

        $hasUserALeague = $user->leagues->filter(static fn (League $league) => $league->pivot->user_id === $user->id && 'pending' !== $league->pivot->status)->count() > 0;
        if ($hasUserALeague) {
            $request->merge(['league_id' => $user->leagues->first()->id]);

            return $next($request);
        }

        return redirect(route('leagues.show'))->with('error_message', 'Devi essere iscritto ad una lega per accedere');
    }
}
