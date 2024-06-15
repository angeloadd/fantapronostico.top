<?php

namespace App\Console\Commands;

use App\Models\Game;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotCommand extends Command
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
        $game = Game::where('started_at', '<', now()->addMinutes(60))
            ->where('started_at', '>', now()->addMinutes(59))
            ->first();

        if ($game === null) {
            $game = Game::where('started_at', '<', now()->addMinutes(60 * 24))
                ->where('started_at', '>', now()->addMinutes((60 * 23) + 59))
                ->first();
        }

        if($game === null){
            return 1;
        }

        try {
            $ciao = Telegram::bot('fpbot');
            $ciao->sendMessage([
                'chat_id' => -1001766446905,
                'text' => view('telegram.game', compact('game'))->render(),
                'parse_mode' => 'HTML',
            ]);

            return self::SUCCESS;
        } catch (Exception $e) {
            Log::channel('schedule')->error($e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return self::FAILURE;
        }
    }
}
