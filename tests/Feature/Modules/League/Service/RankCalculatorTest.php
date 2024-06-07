<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\League\Service;

use App\Helpers\Ranking\RankingCalculator;
use App\Helpers\Ranking\UserRank;
use App\Models\Game;
use App\Models\GameGoal;
use App\Models\Player;
use App\Models\Tournament;
use App\Modules\Auth\Models\User;
use App\Modules\League\Models\League;
use App\Modules\Tournament\Models\Team;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

final class RankCalculatorTest extends TestCase
{
    public function test_calculate(): void
    {
        $tournament = Tournament::factory()
            ->hasGames()
            ->create();
        $league = League::create([
            'tournament_id' => $tournament->id,
            'name' => 'Test',
        ]);
        $homeTeam = Team::factory()
            ->hasPlayers()
            ->create();
        $awayTeam = Team::factory()
            ->hasPlayers()
            ->create();

        /** @var Game $game */
        $game = $tournament->games->first();
        $game->teams()->attach($homeTeam, ['is_away' => false]);
        $game->teams()->attach($awayTeam, ['is_away' => true]);
        User::factory(10)
            ->hasPredictions(['game_id' => $game->id])->create();

        $game = $tournament->games->last();
        $game->teams()->attach($homeTeam, ['is_away' => false]);
        $game->teams()->attach($awayTeam, ['is_away' => true]);
        $scorerId = $game->home_team->players->first()->id;
        $user1 = User::factory()
            ->hasPredictions([
                'game_id' => $game->id,
                'sign' => 'x',
                'home_score' => '1',
                'away_score' => '0',
                'home_scorer_id' => $scorerId,
                'away_scorer_id' => 0,
            ])->create();
        $user2 = User::factory()
            ->hasPredictions([
                'game_id' => $game->id,
                'sign' => '1',
                'home_score' => '2',
                'away_score' => '0',
                'home_scorer_id' => $scorerId,
                'away_scorer_id' => -1,
            ])->create();
        $user3 = User::factory()
            ->hasPredictions([
                'game_id' => $game->id,
                'sign' => '2',
                'home_score' => '0',
                'away_score' => '1',
                'home_scorer_id' => 0,
                'away_scorer_id' => $game->away_team->players->first()->id,
            ])->create();

        $league->users()->attach(collect([$user1->id, $user2->id, $user3->id]), ['status' => 'accepted']);

        $homeTeam->players->map(static fn (Player $player) => $player->games()->attach($game));
        $awayTeam->players->map(static fn (Player $player) => $player->games()->attach($game));

        $game->update([
            'status' => 'finished',
        ]);

        $goal = GameGoal::factory()->create([
            'game_id' => $game->id,
            'player_id' => $scorerId,
        ]);

        $calculator = new RankingCalculator();
        $rank = $calculator->get();
        Cache::forget('usersRank');
        /** @var UserRank $rank1 */
        $rank1 = $rank->filter(static fn (UserRank $rank) => $rank->userId() === $user1->id)->first();
        /** @var UserRank $rank2 */
        $rank2 = $rank->filter(static fn (UserRank $rank) => $rank->userId() === $user2->id)->first();
        /** @var UserRank $rank3 */
        $rank3 = $rank->filter(static fn (UserRank $rank) => $rank->userId() === $user3->id)->first();

        $this->assertSame(8, $rank1->total());
        $this->assertSame(3, $rank2->total());
        $this->assertSame(0, $rank3->total());
    }
}
