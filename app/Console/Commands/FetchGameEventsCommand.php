<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\ApiClients\ApiClientInterface;
use App\Helpers\ApiClients\Exception\InvalidApisportTokenException;
use App\Helpers\ApiClients\Exception\MissingApisportTokenException;
use App\Helpers\ApiClients\ExternalSystemUnavailableException;
use App\Helpers\Mappers\Apisport\GameEventsMapper;
use App\Helpers\Ranking\RankingCalculatorInterface;
use App\Models\Game;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
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

    public function handle(ApiClientInterface $apisport): int
    {
        $count = 0;
        try {
            $games = Game::notCompletedToday(now());
            if (0 === $games->count()) {
                return self::INVALID;
            }
            /** @var Game $game */
            foreach ($games as $game) {
                /** @var Carbon $date */
                $date = $game->started_at;
                if ($date->addHour()->addMinutes(70)->gte(now())) {
                    continue;
                }
                $isFinished = $apisport->get('fixtures?id=' . $game->id);
                if ( ! in_array($isFinished['response'][0]['fixture']['status']['short'], ['FT', 'AET', 'PEN'])) {
                    continue;
                }
                $response = $apisport->get('fixtures/events?fixture=' . $game->id . '&type=Goal');
                $events = GameEventsMapper::fromArray($response['response'], $game);
                $game->update($events->toArray());
                $count++;
            }
        } catch (MissingApisportTokenException|InvalidApisportTokenException $e) {
            Log::error(
                'Failed to fetch: ' . $e->getMessage(),
                [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            $this->error('Failed to fetch: ' . $e->getMessage());

            return self::FAILURE;
        } catch (ExternalSystemUnavailableException $e) {
            Log::error(
                $e->getMessage(),
                [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            $this->error($e->getMessage());

            return self::FAILURE;
        } catch (Throwable $e) {
            Log::error(
                $e->getMessage(),
                [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]
            );
        }

        if ($count > 0) {
            Cache::forget('usersRank');
            app(RankingCalculatorInterface::class)->get();
        }

        $this->info('updated ' . $count . ' matches');

        return self::SUCCESS;
    }
}
