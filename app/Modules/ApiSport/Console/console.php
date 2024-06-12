<?php

declare(strict_types=1);

use App\Models\Game;
use App\Models\Tournament;

$doScheduleBeforeTournamentIsFinished = static fn () => ! empty(Tournament::first()
    ?->final_started_at
    ?->addHours(6)
    ?->isFuture()
);

Schedule::call(
    static function (): void {
        Artisan::call('fp:teams:get', ['--league' => 4, '--season' => 2024]);
        Artisan::call('fp:fetch:games');
        Artisan::call('fp:fetch:players');
    }
)->dailyAt('04:00')
    ->when($doScheduleBeforeTournamentIsFinished);

Schedule::command('fp:fetch:games:events')
    ->everyThirtyMinutes()
    ->between('16:30', '02:00');

Schedule::command('fp:fetch:champions')
    ->everyFiveMinutes()
    ->when(
        static fn () => Tournament::first()?->final_started_at?->isPast() &&
        Game::all()->every('status', '=', 'finished')
    );
