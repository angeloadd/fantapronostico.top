<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\Mappers\Apisport\GameEventsMapper;
use App\Helpers\Ranking\RankingCalculatorInterface;
use App\Models\Game;
use App\Modules\ApiSport\Client\ApiSportClientInterface;
use App\Modules\ApiSport\Exceptions\ExternalSystemUnavailableException;
use App\Modules\ApiSport\Exceptions\InvalidApisportTokenException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

final class FetchGameEventsCommand extends Command
{
    private const TWO_HOURS_UNIX = 60 * 60 * 2;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fp:fetch:games:events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle(ApiSportClientInterface $apisport): int
    {
        $count = 0;
        try {
            $games = Game::all();
            if (0 === $games->count()) {
                return self::INVALID;
            }

            /** @var Game $game */
            foreach ($games as $key => $game) {
                if (($key + 1) % 5 === 0) {
                    sleep(60);
                }
                $this->info('Call ' . ($key + 1) . ' out of ' . $games->count() . ': ' . $game->home_team->name . ' vs ' . $game->away_team->name);
                $date = $game->started_at;
                if ($date->addHours(2)->addMinutes(10)->gte(now())) {
                    continue;
                }
                $isFinished = $apisport->get('fixtures', ['id' => $game->id]);
                if ( ! in_array($isFinished['response'][0]['fixture']['status']['short'], ['FT', 'AET', 'PEN'])) {
                    continue;
                }
                $response = $apisport->get('fixtures/events', ['id' => $game->id, 'type' => 'Goal']);
                $events = GameEventsMapper::fromArray($response['response'], $game);
                $game->addGameEvent($events->toArray());
                $count++;
            }
        } catch (ExternalSystemUnavailableException|InvalidApisportTokenException $e) {
            Log::error(
                'Failed to fetch: ' . $e->getMessage(),
                [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            $this->error('Failed to fetch: ' . $e->getMessage());

            return self::FAILURE;
        } catch (Throwable $e) {
            Log::error(
                $e->getMessage(),
                [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            $this->error($e->getMessage());
        }

        if ($count > 0) {
            Cache::forget('usersRank');
            app(RankingCalculatorInterface::class)->get();
        }

        $this->info('updated ' . $count . ' matches');

        return self::SUCCESS;
    }
}
