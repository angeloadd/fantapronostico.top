<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\FetchGameEventsCommand;
use App\Console\Commands\FetchGamesCommand;
use App\Console\Commands\FetchPlayersCommand;
use App\Console\Commands\FetchTeamsCommand;
use App\Console\Commands\FetchWinnerAndTopScorerCommand;
use App\Console\Commands\FixPlayersCommand;
use App\Models\Game;
use App\Models\Tournament;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

final class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        FetchGamesCommand::class,
        FetchPlayersCommand::class,
        FetchTeamsCommand::class,
        FetchGameEventsCommand::class,
        FetchWinnerAndTopScorerCommand::class,
        FixPlayersCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //        $schedule->command('fp:fetch:team')
        //            ->timezone('Europe/Rome')
        //            ->dailyAt('01:05');
        //        $schedule->command('fp:fetch:games')
        //            ->timezone('Europe/Rome')
        //            ->dailyAt('01:10');
        //        $schedule->command('fp:fetch:players')
        //            ->timezone('Europe/Rome')
        //            ->dailyAt('01:15');
        //        $schedule->command('fp:fix:players')
        //            ->timezone('Europe/Rome')
        //            ->dailyAt('02:15');
        //        $this->scheduleGamesResultFetch($schedule);
        //        $this->scheduleFetchChampion($schedule);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    private function scheduleGamesResultFetch(Schedule $schedule): void
    {
        if (now()->gt(Carbon::create('29.12.2022'))) {
            $schedule->command('fp:fetch:games:events')
                ->hourlyAt(['15', '30'])
                ->timezone('Europe/Rome')
                ->between('13:00', '14:00');
            $schedule->command('fp:fetch:games:events')
                ->hourlyAt(['15', '30'])
                ->timezone('Europe/Rome')
                ->between('16:00', '17:00');
            $schedule->command('fp:fetch:games:events')
                ->hourlyAt(['15', '30'])
                ->timezone('Europe/Rome')
                ->between('19:00', '20:00');
            $schedule->command('fp:fetch:games:events')
                ->hourlyAt(['15', '30'])
                ->timezone('Europe/Rome')
                ->between('22:00', '23:00');
        } else {
            $schedule->command('fp:fetch:games:events')
                ->everyTenMinutes()
                ->timezone('Europe/Rome')
                ->between('18:00', '00:00');
        }
    }

    private function scheduleFetchChampion(Schedule $schedule): void
    {
        if (
            now()->lt(Carbon::createFromTimestamp(Tournament::fisrt()->final_started_at)->addHours(2)) &&
            Game::all()->every('status', '=', 'completed')
        ) {
            $schedule->command('fp:fetch:champions')
                ->everyMinute();
        }
    }
}
