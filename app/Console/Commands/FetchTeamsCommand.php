<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\ApiClients\ApiClientInterface;
use App\Helpers\ApiClients\Exception\InvalidApisportTokenException;
use App\Helpers\ApiClients\Exception\MissingApisportTokenException;
use App\Helpers\ApiClients\ExternalSystemUnavailableException;
use App\Helpers\Mappers\Apisport\TeamMapperCollection;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

final class FetchTeamsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fp:fetch:teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle(ApiClientInterface $apisport): int
    {
        try {
            $response = $apisport->get('teams?league=4&season=2024');
            $teams = TeamMapperCollection::fromArray($response['response']);
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
            Team::upsertMany($teams);
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

        return self::SUCCESS;
    }
}
