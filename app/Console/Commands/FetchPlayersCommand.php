<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\ApiClients\ApiClientInterface;
use App\Helpers\ApiClients\Exception\InvalidApisportTokenException;
use App\Helpers\ApiClients\Exception\MissingApisportTokenException;
use App\Helpers\ApiClients\ExternalSystemUnavailableException;
use App\Helpers\Mappers\Apisport\PlayerMapperCollection;
use App\Models\Player;
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
            $page = 1;
            do {
                if (0 === $page % 10) {
                    sleep(60);
                }
                $response = $apisport->get('players?league=4&season=2024&page=' . $page);
                $max = $response['paging']['total'];
                $page++;
                $players = $players->add($response['response']);
            } while ($page <= $max);
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
