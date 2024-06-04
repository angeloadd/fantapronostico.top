<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\Mappers\Apisport\PlayerMapperCollection;
use App\Models\Player;
use App\Models\Team;
use App\Modules\ApiSport\Client\ApiSportClientInterface;
use App\Modules\ApiSport\Exceptions\ExternalSystemUnavailableException;
use App\Modules\ApiSport\Exceptions\InvalidApisportTokenException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

final class FetchPlayersCommand extends Command
{
    protected $signature = 'fp:fetch:players';

    protected $description = 'Command description';

    public function handle(ApiSportClientInterface $apisport): int
    {
        try {
            $players = PlayerMapperCollection::fromArray([]);
            $teams = Team::all();
            $teams->each(function (Team $team, int $key) use ($apisport, &$players): void {
                if ((0 === ($key + 1) % 10)) {
                    $this->info('Call done' . ($key + 1));
                    sleep(60);
                }

                $response = $apisport->get('/players/squads', ['team' => $team->api_id]);

                $players = $players->add($response['response'][0]);
            });
            unset($response);
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
