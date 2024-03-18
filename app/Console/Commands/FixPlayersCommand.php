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
    protected $signature = 'fp:fix:players';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function insertPlayerOrUpdate($player): void
    {
        Player::updateOrInsert(['id' => $player['id']], $player);
    }

    public function handle(): int
    {
        try {
            Player::find(36920)?->delete();
            Player::find(47302)?->delete();
            Player::find(47348)?->delete();
            Player::where(['name' => 'B. Drągowski', 'team_id' => 24])?->delete();
            Player::find(105)?->update(['name' => 'F. Ballo-Touré']);
            Player::find(266)?->update(['name' => 'Á. Di María']);
            Player::find(18592)?->update(['name' => 'Loum N\'Diaye']);
            Player::find(304)?->delete();
            Player::find(26315)?->delete();
            Player::find(1854)?->delete();
            Player::find(269)?->delete();
            Player::find(412)?->delete();
            Player::find(918)?->delete();
            Player::find(759)?->delete();

            if (null === Player::find(21104)) {
                $this->insertPlayerOrUpdate([
                    'id' => 21104,
                    'name' => 'R. Kolo Muani',
                    'firstname' => 'Randal',
                    'lastname' => 'Kolo Muani',
                    'injured' => false,
                    'photo' => 'https://media.api-sports.io/football/players/21104.png',
                    'team_id' => 2,
                ]);
            }
            if (null === Player::find(53)) {
                $this->insertPlayerOrUpdate(['id' => 53,
                    'name' => 'Á. Correa',
                    'firstname' => 'Ángel Martín',
                    'lastname' => 'Correa Martínez',
                    'injured' => false,
                    'photo' => 'https://media.api-sports.io/football/players/53.png',
                    'team_id' => 26,
                ]);
            }
            if (null === Player::find(6067)) {
                $this->insertPlayerOrUpdate([
                    'id' => 6067,
                    'name' => 'T. Almada',
                    'firstname' => 'Thiago Ezequiel',
                    'lastname' => 'Almada',
                    'injured' => false,
                    'photo' => 'https://media.api-sports.io/football/players/6067.png',
                    'team_id' => 26,
                ]);
            }
        } catch (Throwable $e) {
            Log::error('fix not worked', ['trace' => $e->getTraceAsString()]);

            $this->error($e->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
