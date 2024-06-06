<?php

declare(strict_types=1);

use App\Modules\Auth\Http\Controller\LeagueController;
use Illuminate\Routing\Router;

/** @var Router $r */
$r->middleware('auth')->group(static function (Router $api): void {
    $api->get('/leghe', [LeagueController::class, 'show'])->name('leagues.show');
    $api->post('/leghe/richiesta', [LeagueController::class, 'requestSubscription'])->name('leagues.subscribe');
    $api->get('leghe/attendi', [LeagueController::class, 'subscriptionPending'])->name('leagues.pending');
});
