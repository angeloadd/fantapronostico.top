<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Game;
use App\Models\Player;
use DateTimeImmutable;
use Exception;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Feature\Helpers\FactoryHelper;
use Tests\TestCase;

final class GameTest extends TestCase
{
    public static function provideStatus(): iterable
    {
        yield 'not started' => ['not_started'];
        yield 'ongoing' => ['ongoing'];
        yield 'completed' => ['finished'];
        yield 'invalid status' => ['invalid'];
    }

    public function test_a_game_can_be_in_a_tournament(): void
    {
        $tournament = FactoryHelper::makeTournament();
        $game = FactoryHelper::makeGame($tournament);

        self::assertSame(
            $tournament->games->first()->id,
            $game->id
        );
    }

    public function test_a_game_can_have_home_and_away_team(): void
    {
        $tournament = FactoryHelper::makeTournament();
        $game = FactoryHelper::makeGame($tournament);

        $home = FactoryHelper::makeTeam();
        $away = FactoryHelper::makeTeam();
        $game->teams()->attach($home, ['is_away' => 0]);
        $game->teams()->attach($away, ['is_away' => 1]);
        $game->save();
        $game->refresh();

        self::assertSame($home->id, $game->home_team->id);
        self::assertSame($away->id, $game->away_team->id);
    }

    public function test_a_game_can_have_players(): void
    {
        $tournament = FactoryHelper::makeTournament();
        $game = FactoryHelper::makeGame($tournament);
        $player = FactoryHelper::makePlayer();

        $game->players()->attach($player->id);

        $game->refresh();
        $player->refresh();
        $tournament->refresh();

        self::assertCount(
            1,
            $game->players
                ->filter(static fn (Player $gamePlayer): bool => $gamePlayer->id === $player->id)
        );
    }

    public function test_a_game_can_be_saved(): void
    {
        $testNow = '2023-12-31 12:00:00';
        Carbon::setTestNow($testNow);
        $tournament = FactoryHelper::makeTournament();
        $startedAt = '2023-10-28 12:50:00';
        $attributes = [
            'tournament_id' => $tournament->id,
            'stage' => 'stage_name',
            'status' => 'not_started',
            'started_at' => new DateTimeImmutable($startedAt),
        ];
        $game = Game::create($attributes);

        $attributes['id'] = $game->id;
        $attributes['created_at'] = $testNow;
        $attributes['updated_at'] = $testNow;
        $attributes['started_at'] = $startedAt;
        $this->assertDatabaseHas('games', $attributes);
    }

    public function test_started_at_is_casted_to_date(): void
    {
        FactoryHelper::makeGame(FactoryHelper::makeTournament());

        $this->assertInstanceOf(Carbon::class, Game::first()?->started_at);
    }

    #[DataProvider('provideStatus')]
    public function test_game_status_is_enum(string $status): void
    {
        if ('invalid' === $status) {
            $this->expectException(Exception::class);
        }

        Game::create([
            'tournament_id' => FactoryHelper::makeTournament()->id,
            'stage' => 'stage_name',
            'status' => $status,
            'started_at' => now(),
        ]);

        if ('invalid' !== $status) {
            $this->assertDatabaseCount('games', 1);
        }
    }
}
