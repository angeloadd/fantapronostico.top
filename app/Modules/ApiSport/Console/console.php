<?php

declare(strict_types=1);

use App\Models\Game;
use App\Models\Tournament;

$doScheduleBeforeTournamentIsFinished = static fn () => Tournament::first()
    ?->final_started_at
    ?->addHours(6)
    ?->isFuture();

Schedule::command('fp:teams:get')
    ->dailyAt('04:00')
    ->when($doScheduleBeforeTournamentIsFinished);
Schedule::command('fp:games:get')
    ->dailyAt('04:05')
    ->when($doScheduleBeforeTournamentIsFinished);
Schedule::command('fp:players:get')
    ->dailyAt('04:10')
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
