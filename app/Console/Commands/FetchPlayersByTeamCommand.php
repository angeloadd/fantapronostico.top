<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\ApiClients\ApiClientInterface;
use App\Helpers\ApiClients\Exception\InvalidApisportTokenException;
use App\Helpers\ApiClients\Exception\MissingApisportTokenException;
use App\Helpers\ApiClients\ExternalSystemUnavailableException;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

final class FetchPlayersByTeamCommand extends Command
{
    protected $signature = 'fp:fetch:players:teams';

    protected $description = 'Command description';

    public function handle(ApiClientInterface $apisport): int
    {
        try {
            $counter = 0;
            $teams = Team::all();
            foreach ($teams as $team) {
                $response = $apisport->get('players/squads?team=' . $team->id);
                $counter++;
                foreach ($response['response'][0]['players'] as $player) {
                    $fromDB = Player::find($player['id']);
                    if (null === $fromDB) {
                        $fromDB = new Player();
                    }
                    $fromDB->id = $player['id'];
                    $fromDB->name = $player['name'];
                    $fromDB->photo = $player['photo'];
                    $fromDB->team_id = $team->id;
                    $fromDB->save();
                }
                if ($counter % 10) {
                    sleep(60);
                }
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
        }

        $this->info('Updated ' . Player::count() . ' players');

        return self::SUCCESS;
    }
}
