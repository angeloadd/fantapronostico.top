<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Tournament;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

final class AddTournamentCommand extends Command
{
    protected $signature = 'fp:tournament:add';

    protected $description = 'Add a new tournament';

    public function handle(): int
    {
        $tournament = Tournament::createOrFirst([
            'country' => 'World',
            'name' => 'UEFA Euro Cup',
            'logo' => 'https://media.api-sports.io/football/leagues/4.png',
            'is_cup' => true,
            'season' => 2024,
            'api_id' => 4,
            'started_at' => Carbon::createFromImmutable(new DateTimeImmutable('2024-06-14 21:00:00', new DateTimeZone('Europe/Berlin'))),
            'final_started_at' => Carbon::createFromImmutable(new DateTimeImmutable('2024-07-14 21:00:00', new DateTimeZone('Europe/Berlin'))),
        ]);

        $tournament->leagues()->create([
            'name' => 'Fantapronostico2024',
        ]);

        return self::SUCCESS;
    }
}
