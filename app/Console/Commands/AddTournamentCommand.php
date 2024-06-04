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
    protected $signature = 'tournament:add';
    protected $description = 'Add a new tournament';

    public function handle(): int
    {
        Tournament::createOrFirst([
            'id' => 4,
            'country' => 'World',
            'name' => 'Euro Championship',
            'is_cup' => true,
            'final_started_at' => Carbon::createFromImmutable(new DateTimeImmutable('2024-07-14 21:00:00', new DateTimeZone('Europe/Berlin'))),
        ]);
        return 0;
    }
}
