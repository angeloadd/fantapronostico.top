<?php

declare(strict_types=1);

use App\Models\Game;
use App\Models\Tournament;
use Illuminate\Support\Carbon;

try {
    // Run Schedules maximum 10 hours after final started
    /** @var ?Carbon $finalStartedAt */
    $finalStartedAt = Tournament::first()?->final_started_at;
    if ($finalStartedAt->addHours(10)->isFuture()) {
        Schedule::command('fp:teams:get')
            ->dailyAt('02:05');
        Schedule::command('fp:fetch:games')
            ->dailyAt('02:10');
        Schedule::command('fp:fetch:players')
            ->dailyAt('02:15');

        Schedule::command('fp:fetch:games:events')
            ->hourlyAt(['15', '30'])
            ->between('17:00', '18:00');
        Schedule::command('fp:fetch:games:events')
            ->hourlyAt(['15', '30'])
            ->between('19:00', '10:00');
        Schedule::command('fp:fetch:games:events')
            ->hourlyAt(['15', '30'])
            ->between('23:00', '23:50');

        $isPast = $finalStartedAt?->isPast();
        $areAllGamesFinished = Game::all()->every('status', '=', 'finished');
        if ($isPast && $areAllGamesFinished) {
            Schedule::command('fp:fetch:champions')
                ->everyThreeMinutes();
        }
    }
} catch (Throwable $e) {
    Log::error($e->getMessage());
}
