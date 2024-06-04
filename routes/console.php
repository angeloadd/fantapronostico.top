<?php

declare(strict_types=1);

use App\Models\Game;
use App\Models\Tournament;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function (): void {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

try {
    // Run Schedules maximum 10 hours after final started
    /** @var Carbon $finalStartedAt */
    $finalStartedAt = Tournament::first()?->final_started_at;
    if (now()->lt($finalStartedAt->addHours(10))) {
        Schedule::command('fp:fetch:team')
            ->timezone('Europe/Rome')
            ->dailyAt('01:05');
        Schedule::command('fp:fetch:games')
            ->timezone('Europe/Rome')
            ->dailyAt('01:10');
        Schedule::command('fp:fetch:players')
            ->timezone('Europe/Rome')
            ->dailyAt('01:15');
        Schedule::command('fp:fix:players')
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

        $isPast = $finalStartedAt->isPast();
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
