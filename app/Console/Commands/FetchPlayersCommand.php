<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\ApiClients\ApiClientInterface;
use App\Helpers\ApiClients\Apisport;
use App\Helpers\ApiClients\Exception\InvalidApisportTokenException;
use App\Helpers\ApiClients\Exception\MissingApisportTokenException;
use App\Helpers\ApiClients\ExternalSystemUnavailableException;
use App\Helpers\Mappers\Apisport\PlayerMapperCollection;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

final class FetchPlayersCommand extends Command
{
    protected $signature = 'fp:fetch:players';

    protected $description = 'Command description';

    public function handle(ApiClientInterface $apisport): int
    {
        try {
            $players = PlayerMapperCollection::fromArray([]);
            $teams = Team::all();
            $teams->each(function (Team $team, int $key) use ($apisport, &$players): void {
                if ((0 === ($key + 1) % 10) && $apisport instanceof Apisport) {
                    $this->info('Call done' . ($key + 1));
                    sleep(60);
                }

                $uri = '/players/squads?team=' . $team->id;
                $response = $apisport->get($uri);

                $players = $players->add($response['response'][0]);
            });
            unset($response);
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
        }

        try {
            Player::upsertMany($players);
        } catch (Throwable $e) {
            Log::error(
                'Internal error: ' . $e->getMessage(),
                [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            $this->error('Internal error: ' . $e->getMessage());

            return self::FAILURE;
        }

        $this->info('Updated ' . $players->count() . ' players');

        return self::SUCCESS;
    }
}
