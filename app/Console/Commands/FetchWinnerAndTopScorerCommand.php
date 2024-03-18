<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\ApiClients\ApiClientInterface;
use App\Helpers\ApiClients\Exception\InvalidApisportTokenException;
use App\Helpers\ApiClients\Exception\MissingApisportTokenException;
use App\Helpers\ApiClients\ExternalSystemUnavailableException;
use App\Helpers\Mappers\Apisport\TopScorers;
use App\Helpers\Mappers\Apisport\Winner;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

final class FetchWinnerAndTopScorerCommand extends Command
{
    private const TWO_HOURS_UNIX = 60 * 60 * 2;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fp:fetch:champions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle(ApiClientInterface $apisport): int
    {
        $players = [];
        $winner = 0;
        try {
            $response = $apisport->get('players/topscorers?league=1&season=2022');
            $players = TopScorers::fromArray($response['response']);
            unset($response);
            $response = $apisport->get('fixtures?league=1&season=2022');
            $winner = Winner::fromArray($response['response']);
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
            foreach ($players->toArray() as $player) {
                $player = Player::find($player['id']);
                $player->top_scorer = true;
                $player->save();
            }
            if ($winner->toInt()) {
                $winner = Team::find($winner->toInt());
                $winner->winner = true;
                $winner->save();
            }
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
