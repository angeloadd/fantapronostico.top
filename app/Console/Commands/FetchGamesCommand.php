<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\Mappers\Apisport\GameMapperCollection;
use App\Models\Game;
use App\Modules\ApiSport\Client\ApiSportClientInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

final class FetchGamesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fp:fetch:games';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle(ApiSportClientInterface $apisport): int
    {
        try {
            $response = $apisport->get('fixtures', ['league' => 4, 'season' => 2024]);
            $games = GameMapperCollection::fromArray($response['response']);
            unset($response);
        } catch (Throwable $e) {
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
            Game::upsertMany($games);
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
