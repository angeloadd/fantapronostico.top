<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Game;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

final class BotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fp:bot:telegram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $games = $this->getGamesFromTo(59, 60);

        if ($games->isEmpty()) {
            $games = $this->getGamesFromTo((60 * 23) + 59, 60 * 24);
        }

        if ($games->isEmpty()) {
            return 1;
        }

        try {
            $bot = Telegram::bot('fpbot');
            foreach ($games as $game) {
                $bot->sendMessage([
                    'chat_id' => -1001766446905,
                    'text' => view('telegram.game', compact('game'))->render(),
                    'parse_mode' => 'HTML',
                ]);
            }

            return self::SUCCESS;
        } catch (Exception $e) {
            Log::channel('schedule')->error($e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return self::FAILURE;
        }
    }

    private function getGamesFromTo(int $from, int $to): Collection
    {
        $now = now();

        return  Game::whereBetween('started_at', [$now->addMinutes($from), $now->addMinutes($to)])->get();
    }
}
