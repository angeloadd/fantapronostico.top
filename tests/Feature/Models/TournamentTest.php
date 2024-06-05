<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Helpers\Constants;
use App\Models\Player;
use App\Models\Tournament;
use App\Modules\Tournament\Models\Team;
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
        $date = '2023-12-31T23:00:00.000000Z';
        $attributes = [
            'season' => 2022,
            'api_id' => 1,
            'name' => 'tournament_name',
            'logo' => 'logo.png',
            'country' => 'World',
            'is_cup' => true,
            'started_at' => $date,
            'final_started_at' => $date,
        ];
        $tournament = Tournament::create($attributes);

        $this->assertSame($attributes['season'], $tournament->season);
        $this->assertSame($attributes['api_id'], $tournament->api_id);
        $this->assertSame($attributes['name'], $tournament->name);
        $this->assertSame($attributes['logo'], $tournament->logo);
        $this->assertSame($attributes['country'], $tournament->country);
        $this->assertSame($attributes['is_cup'], $tournament->is_cup);
        $this->assertSame($attributes['started_at'], $tournament->started_at->format(Constants::ISO_DATE_FORMAT));
        $this->assertSame($attributes['final_started_at'], $tournament->final_started_at->format(Constants::DISPLAY));
    }
}
