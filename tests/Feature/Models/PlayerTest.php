<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Exceptions\ClubAndNationalTeamsCannotBeTheSameException;
use App\Models\Exceptions\ClubTeamCannotBeNationalException;
use App\Models\Exceptions\NationalTeamCannotBeClubException;
use App\Models\Game;
use App\Models\GameGoal;
use App\Models\Player;
use Tests\Feature\Helpers\FactoryHelper;
use Tests\TestCase;

final class PlayerTest extends TestCase
{
    /**
     * @testdox Step creation to test a player can have bot club_id and national_id as null or just one of the two
     * filled
     */
    public function test_a_player_can_have_a_national_team_and_a_club_team(): void
    {
        $nationalTeam = FactoryHelper::makeTeam();
        $clubTeam = FactoryHelper::makeTeam(false);
        $player = FactoryHelper::makePlayer();

        $player->club()->associate($clubTeam);
        $player->save();
        $player->national()->associate($nationalTeam);
        $player->save();

        $nationalTeam->refresh();
        $clubTeam->refresh();
        $player->refresh();

        self::assertSame($nationalTeam->id, $player->national->id);
        self::assertSame($clubTeam->id, $player->club->id);
    }

    public function test_a_player_can_take_part_to_a_tournament(): void
    {
        $tournament = FactoryHelper::makeTournament();
        $player = FactoryHelper::makePlayer();

        $player->tournaments()->attach($tournament->id);

        $player->save();

        $player->refresh();
        $tournament->refresh();

        self::assertCount(
            1,
            $player->tournaments
                ->first()
                ->players
                ->filter(static fn (Player $tournamentPlayer): bool => $tournamentPlayer->id === $player->id)
        );
    }

    public function test_a_player_can_take_part_to_a_game_and_it_is_automatically_attached_to_the_tournament(): void
    {
        $tournament = FactoryHelper::makeTournament();
        $game = FactoryHelper::makeGame($tournament);

        $player = FactoryHelper::makePlayer();
        $player->games()->attach($game->id);
        $player->save();

        $player->refresh();
        $tournament->refresh();
        $game->refresh();

        self::assertCount(
            1,
            $player->games
                ->first()
                ->players
                ->filter(static fn (Player $gamePlayer): bool => $gamePlayer->id === $player->id)
        );
    }

    public function test_a_player_can_score_a_goal_in_a_game_and_by_default_it_is_not_an_autogoal(): void
    {
        $tournament = FactoryHelper::makeTournament();
        $game = FactoryHelper::makeGame($tournament);
        $player = FactoryHelper::makePlayer();

        $player->games()->attach($game->id);

        $gameGoal = GameGoal::factory([
            'game_id' => $game->id,
            'player_id' => $player->id,
            'scored_at' => now(),
        ])->create();

        $game->fresh();
        $tournament->fresh();
        $player->fresh();
        $gameGoal->fresh();

        self::assertSame(
            $gameGoal->game_id,
            $player->games->filter(static fn (Game $gameForPlayer): bool => $gameForPlayer->id === $game->id)->first()->id
        );
    }

    public function test_a_player_cannot_have_same_team_for_national_and_club(): void
    {
        $team = FactoryHelper::makeTeam();

        $this->expectException(ClubAndNationalTeamsCannotBeTheSameException::class);
        Player::factory(['club_id' => $team->id, 'national_id' => $team->id])->create();
        $this->assertDatabaseEmpty('players');
    }

    public function test_a_player_cannot_have_a_national_team_as_club(): void
    {
        $team = FactoryHelper::makeTeam();

        $this->expectException(ClubTeamCannotBeNationalException::class);
        Player::factory(['club_id' => $team->id])->create();
        $this->assertDatabaseEmpty('players');
    }

    public function test_a_player_cannot_have_a_club_team_as_national(): void
    {
        $team = FactoryHelper::makeTeam(false);

        $this->expectException(NationalTeamCannotBeClubException::class);
        Player::factory(['national_id' => $team->id])->create();
        $this->assertDatabaseEmpty('players');
    }

    public function test_a_player_can_be_persisted(): void
    {
        $attributes = [
            'displayed_name' => 'J. Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ];
        Player::create($attributes);

        $attributes['club_id'] = null;
        $attributes['national_id'] = null;

        $this->assertDatabaseHas('players', $attributes);
    }

    public function test_a_player_team_on_delete_are_set_to_null(): void
    {
        $team = FactoryHelper::makeTeam();
        $club = FactoryHelper::makeTeam(false);
        $attributes = [
            'displayed_name' => 'J. Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'national_id' => $team->id,
            'club_id' => $club->id,
        ];
        Player::create($attributes);

        $this->assertDatabaseHas('players', $attributes);
        $team->delete();
        $club->delete();
        $attributes['club_id'] = null;
        $attributes['national_id'] = null;
        $this->assertDatabaseHas('players', $attributes);
    }

    public function test_a_player_team_are_cascade_updated(): void
    {
        $team = FactoryHelper::makeTeam();
        $club = FactoryHelper::makeTeam(false);
        $attributes = [
            'displayed_name' => 'J. Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'national_id' => $team->id,
            'club_id' => $club->id,
        ];
        Player::create($attributes);

        $this->assertDatabaseHas('players', $attributes);
        $newId = 100;
        $team->id = $newId;
        $team->save();
        $club->id = $newId + 1;
        $club->save();
        $attributes['club_id'] = $newId + 1;
        $attributes['national_id'] = $newId;
        $this->assertDatabaseHas('players', $attributes);
    }
}
