<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Team;
use Illuminate\Support\Carbon;
use Tests\Feature\Helpers\FactoryHelper;
use Tests\TestCase;

final class TeamTest extends TestCase
{
    public function test_a_team_can_take_part_to_multiple_tournaments(): void
    {
        $tournament1 = FactoryHelper::makeTournament();
        $tournament2 = FactoryHelper::makeTournament();
        $nationalTeam = FactoryHelper::makeTeam();

        $nationalTeam->tournaments()->attach($tournament1->id);
        $nationalTeam->tournaments()->attach($tournament2->id);

        $nationalTeam->refresh();
        $tournament1->refresh();
        $tournament2->refresh();

        self::assertEquals($nationalTeam->tournaments[0]->id, $tournament1->id);
        self::assertEquals($nationalTeam->tournaments[1]->id, $tournament2->id);
    }

    public function test_a_team_can_have_multiple_players_for_national_and_club(): void
    {
        $nationalTeam = FactoryHelper::makeTeam();
        $clubTeam = FactoryHelper::makeTeam(false);

        $player1 = FactoryHelper::makePlayer();
        $player2 = FactoryHelper::makePlayer();
        $player3 = FactoryHelper::makePlayer();

        $player1->national()->associate($nationalTeam)->save();
        $player2->national()->associate($nationalTeam)->save();
        $player2->club()->associate($clubTeam)->save();
        $player3->club()->associate($clubTeam)->save();

        $nationalTeam->refresh();
        $clubTeam->refresh();
        $player1->refresh();
        $player2->refresh();
        $player3->refresh();

        self::assertSame($player1->id, $nationalTeam->players[0]->id);
        self::assertSame($player2->id, $nationalTeam->players[1]->id);
        self::assertCount(2, $nationalTeam->players);
        self::assertSame($player2->id, $clubTeam->players[0]->id);
        self::assertSame($player3->id, $clubTeam->players[1]->id);
        self::assertCount(2, $clubTeam->players);
    }

    public function test_a_team_can_play_multiple_games_as_home_team_or_away_team(): void
    {
        $nationalTeam1 = FactoryHelper::makeTeam();
        $nationalTeam2 = FactoryHelper::makeTeam();

        $tournament1 = FactoryHelper::makeTournament();
        $tournament2 = FactoryHelper::makeTournament();

        $game1 = FactoryHelper::makeGame($tournament1);
        $game2 = FactoryHelper::makeGame($tournament1);
        $game3 = FactoryHelper::makeGame($tournament2);
        $game4 = FactoryHelper::makeGame($tournament2);

        $game1->tournament()->associate($tournament1);
        $game2->tournament()->associate($tournament1);
        $game3->tournament()->associate($tournament2);
        $game4->tournament()->associate($tournament2);

        $game1->teams()->attach($nationalTeam1, ['is_away' => false]);
        $game1->teams()->attach($nationalTeam2, ['is_away' => true]);
        $game2->teams()->attach($nationalTeam2, ['is_away' => 0]);
        $game2->teams()->attach($nationalTeam1, ['is_away' => 1]);
        $game3->teams()->attach($nationalTeam1, ['is_away' => 0]);
        $game3->teams()->attach($nationalTeam2, ['is_away' => 1]);
        $game4->teams()->attach($nationalTeam2, ['is_away' => 0]);
        $game4->teams()->attach($nationalTeam1, ['is_away' => 1]);

        $game1->save();
        $game2->save();
        $game3->save();
        $game4->save();
        $game1->refresh();
        $game2->refresh();
        $game3->refresh();
        $game4->refresh();
        $tournament1->refresh();
        $tournament2->refresh();
        $nationalTeam1->refresh();
        $nationalTeam2->refresh();

        self::assertSame($game1->home_team->id, $nationalTeam1->id);
        self::assertSame($game1->away_team->id, $nationalTeam2->id);
        self::assertSame($game2->home_team->id, $nationalTeam2->id);
        self::assertSame($game2->away_team->id, $nationalTeam1->id);
        self::assertSame($game3->home_team->id, $nationalTeam1->id);
        self::assertSame($game3->away_team->id, $nationalTeam2->id);
        self::assertSame($game4->home_team->id, $nationalTeam2->id);
        self::assertSame($game4->away_team->id, $nationalTeam1->id);
    }

    public function test_a_team_is_persisted_with_correct_properties(): void
    {
        $testNow = '2023-12-31T23:00:00.000000Z';
        Carbon::setTestNow($testNow);
        $attributes = [
            'id' => 100,
            'name' => 'team_name',
            'code' => 'TEN',
            'logo' => 'team_logo',
            'is_national' => true,
        ];
        $team = Team::create($attributes);

        $expected = [
            ...$attributes,
            'updated_at' => $testNow,
            'created_at' => $testNow,
        ];

        self::assertSame($expected, $team->toArray());
    }
}
