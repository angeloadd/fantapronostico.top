<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Player;
use Illuminate\Console\Command;
use Log;
use Throwable;

final class FixPlayersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fp:players:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manual fix for player list where the api did not get updated yet on injured or last our swaps';

    public function insertPlayerOrUpdate($player): void
    {
        Player::updateOrInsert(['id' => $player['id']], $player);
    }

    public function handle(): int
    {
        try {
            dump('Nothing to fix');
        } catch (Throwable $e) {
            Log::error('fix not worked', ['trace' => $e->getTraceAsString()]);

            $this->error($e->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
