<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Player;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Tests\Feature\Helpers\FactoryHelper;
use Tests\TestCase;

final class TournamentTest extends TestCase
{
    public function test_a_tournament_can_have_multiple_games(): void
    {
        $tournament = FactoryHelper::makeTournament();

        for ($i = 0; $i < 24; $i++) {
            FactoryHelper::makeGame($tournament);
        }

        self::assertCount(24, $tournament->games);
    }

    public function test_a_tournament_can_have_multiple_players(): void
    {
        $tournament = FactoryHelper::makeTournament();

        $players = Collection::empty();
        for ($i = 0; $i < 24; $i++) {
            $players->add(FactoryHelper::makePlayer());
        }

        $players->map(static fn (Player $player) => $player->tournaments()->attach($tournament->id));

        self::assertCount(24, $tournament->players);
    }

    public function test_a_tournament_can_have_multiple_teams(): void
    {
        $tournament = FactoryHelper::makeTournament();

        $teams = Collection::empty();
        for ($i = 0; $i < 24; $i++) {
            $teams->add(FactoryHelper::makeTeam());
        }

        $teams->map(static fn (Team $team) => $team->tournaments()->attach($tournament->id));

        self::assertCount(24, $tournament->teams);
    }

    public function test_a_tournament_is_persisted_with_correct_properties(): void
    {
        $testNow = '2023-12-31T23:00:00.000000Z';
        Carbon::setTestNow($testNow);
        $attributes = [
            'id' => 100,
            'name' => 'tournament_name',
            'country' => 'World',
            'is_cup' => true,
        ];
        $tournament = Tournament::create($attributes);

        $expected = [
            ...$attributes,
            'updated_at' => $testNow,
            'created_at' => $testNow,
        ];

        self::assertSame($expected, $tournament->toArray());
    }
}
