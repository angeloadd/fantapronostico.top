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
        Schedule::call(static fn() => Log::info('schedule is running'));
        Schedule::command('fp:teams:get')
            ->timezone('Europe/Rome')
            ->dailyAt('01:05');
        Schedule::command('fp:fetch:games')
            ->timezone('Europe/Rome')
            ->dailyAt('01:10');
        Schedule::command('fp:fetch:players')
            ->timezone('Europe/Rome')
            ->dailyAt('01:15');
        Schedule::command('fp:players:fix')
            ->timezone('Europe/Rome')
            ->dailyAt('02:15');

        Schedule::command('fp:fetch:games:events')
            ->hourlyAt(['15', '30'])
            ->timezone('Europe/Rome')
            ->between('17:00', '18:00');
        Schedule::command('fp:fetch:games:events')
            ->hourlyAt(['15', '30'])
            ->timezone('Europe/Rome')
            ->between('19:00', '10:00');
        Schedule::command('fp:fetch:games:events')
            ->hourlyAt(['15', '30'])
            ->timezone('Europe/Rome')
            ->between('23:00', '23:50');

        $isPast = $finalStartedAt?->isPast();
        $areAllGamesFinished = Game::all()->every('status', '=', 'finished');
        if ($isPast && $areAllGamesFinished) {
            Schedule::command('fp:fetch:champions')
                ->timezone('Europe/Rome')
                ->everyThreeMinutes();
        }
    }
} catch (Throwable $e) {
    Log::error($e->getMessage());
}
