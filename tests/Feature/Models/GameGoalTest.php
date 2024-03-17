<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\GameGoal;
use Tests\Feature\Helpers\FactoryHelper;
use Tests\TestCase;

final class GameGoalTest extends TestCase
{
    public function test_a_goal_is_scored_for_a_game_and_player(): void
    {
        $game = FactoryHelper::makeGame(FactoryHelper::makeTournament());
        $player = FactoryHelper::makePlayer();

        $scoredAt = '2023-12-31T23:00:00.000000Z';
        $gameGoal = GameGoal::create([
            'game_id' => $game->id,
            'player_id' => $player->id,
            'is_autogoal' => true,
            'scored_at' => $scoredAt,
        ]);

        self::assertSame($player->id, $gameGoal->player->id);
        self::assertSame($game->id, $gameGoal->game->id);
        self::assertTrue($gameGoal->is_autogoal);
        self::assertSame($scoredAt, $gameGoal->scored_at);
    }

    public function test_a_goal_is_scored_for_a_game_and_player_and_by_default_is_not_autogoal(): void
    {
        $game = FactoryHelper::makeGame(FactoryHelper::makeTournament());
        $player = FactoryHelper::makePlayer();

        $gameGoal = GameGoal::create([
            'game_id' => $game->id,
            'player_id' => $player->id,
            'scored_at' => now(),
        ]);

        $gameGoal->refresh();

        self::assertFalse($gameGoal->is_autogoal);
    }
}
