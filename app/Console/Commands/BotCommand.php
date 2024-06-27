<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Game;
use App\Modules\League\Dto\TelegramReminderViewDto;
use App\Modules\League\Service\Telegram\TelegramServiceInterface;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

final class BotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fp:bot:telegram {gameId?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(TelegramServiceInterface $telegramService): int
    {
        if ($this->argument('gameId')) {
            $games = collect([Game::find(1189852)]);
        } else {

            $games = $this->getGamesFromTo(59, 60);

            if ($games->isEmpty()) {
                $games = $this->getGamesFromTo((60 * 23) + 59, 60 * 24);
            }

            if ($games->isEmpty()) {
                return 1;
            }
        }

        $dtos = $games->map(
            static fn (Game $game) => new TelegramReminderViewDto(
                $game->id,
                $game->home_team->name,
                $game->away_team->name,
                (string) str($game->started_at->isoFormat('\e\n\t\r\o \i\l D MMMM YYYY \a\l\l\e HH:mm'))->title()
            )
        )->toArray();

        try {
            $telegramService->sendReminder(-1001766446905, $dtos);

            foreach ($this->getRoundPhaseReminderTimes() as $roundPhaseReminderTime) {
                if(abs(now()->unix() - $roundPhaseReminderTime->unix()) < 60) {
                    $telegramService->sendRoundPhaseReminder(-1001766446905);

                }
            }

            return self::SUCCESS;
        } catch (Exception $e) {
            $this->error($e->getMessage());
            Log::channel('schedule')->error($e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return self::FAILURE;
        }
    }

    private function getRoundPhaseReminderTimes(): array
    {
        return [
            Carbon::parse('2024-06-27 21:00:00'),
            Carbon::parse('2024-06-28 09:00:00'),
            Carbon::parse('2024-06-29 09:00:00'),
        ];

    }

    private function getGamesFromTo(int $from, int $to): Collection
    {
        return Game::whereBetween('started_at', [now()->addMinutes($from), now()->addMinutes($to)])->get();
    }
}
