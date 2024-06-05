<?php

declare(strict_types=1);

namespace Tests\Feature\Helpers;

use App\Models\Game;
use App\Models\Player;
use App\Models\Tournament;
use App\Modules\Tournament\Models\Team;
use Tests\TestCase;

final class FactoryHelper extends TestCase
{
    public static function makeTeam(bool $isNational = true): Team
    {
        $type = $isNational ? 'national' : 'club';
        $team = Team::factory()->{$type}()->create();

        self::assertInstanceOf(Team::class, $team);

        return $team;
    }

    public static function makeTournament(): Tournament
    {
        $tournament = Tournament::factory()->create();

        self::assertInstanceOf(Tournament::class, $tournament);

        return $tournament;
    }

    public static function makePlayer(): Player
    {
        $player = Player::factory()->create();

        self::assertInstanceOf(Player::class, $player);

        return $player;
    }

    public static function makeGame(Tournament $tournament): Game
    {
        $game = Game::factory()->for($tournament, 'tournament')->create();

        self::assertInstanceOf(Game::class, $game);

        return $game;
    }
}
