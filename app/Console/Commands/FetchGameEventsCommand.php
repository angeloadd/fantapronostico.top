<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\Mappers\Apisport\GameEventsMapper;
use App\Helpers\Ranking\RankingCalculatorInterface;
use App\Models\Game;
use App\Modules\ApiSport\Client\ApiSportClientInterface;
use App\Modules\ApiSport\Exceptions\ExternalSystemUnavailableException;
use App\Modules\ApiSport\Exceptions\InvalidApisportTokenException;
use App\Modules\League\Models\League;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Throwable;

final class FetchGameEventsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fp:fetch:games:events {--fixture=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle(ApiSportClientInterface $apisport): int
    {
        $option = $this->option('fixture');
        $count = 0;
        try {
            if (is_numeric($option)) {
                $games = collect([Game::find((int) $option)]);
            } else {
                $games = Game::notCompletedToday();
            }

            /** @var Game $game */
            foreach ($games as $key => $game) {
                if (($key + 1) % 5 === 0) {
                    sleep(60);
                }
                $date = $game->started_at;
                if ($date->addMinutes(119)->isFuture()) {
                    continue;
                }

                $this->info('Call ' . ($key + 1) . ' out of ' . $games->count() . ': ' . $game->home_team->name . ' vs ' . $game->away_team->name);
                $isFinished = $apisport->get('fixtures', ['id' => $game->id]);
                if ( ! in_array($isFinished['response'][0]['fixture']['status']['short'], ['FT', 'AET', 'PEN'])) {
                    continue;
                }
                $response = $apisport->get('fixtures/events', ['fixture' => $game->id, 'type' => 'Goal']);

                $events = GameEventsMapper::fromArray($response['response'], $game);

                $game->addGameEvent($events->toArray());
                $count++;
            }
        } catch (ExternalSystemUnavailableException|InvalidApisportTokenException $e) {
            Log::channel('schedule')->error(
                'Failed to fetch: ' . $e->getMessage(),
                [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            $this->error('Failed to fetch: ' . $e->getMessage());

            return self::FAILURE;
        } catch (Throwable $e) {
            dump($e);
            Log::channel('schedule')->error(
                $e->getMessage(),
                [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            $this->error($e->getMessage());
        }

        if ($count > 0) {
            $league = League::first();
            if (null === $league) {
                throw new InvalidArgumentException('Could not find a league for rank');
            }
            app(RankingCalculatorInterface::class)->calculate($league);
        }

        $this->info('updated ' . $count . ' matches');

        return self::SUCCESS;
    }
}
