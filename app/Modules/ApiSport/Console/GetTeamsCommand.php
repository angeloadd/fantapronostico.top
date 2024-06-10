<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Console;

use App\Modules\ApiSport\Request\GetTeamsRequest;
use App\Modules\ApiSport\Service\ApiSportServiceInterface;
use App\Modules\Tournament\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;
use Throwable;

final class GetTeamsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'fp:teams:get';

    /**
     * @var string
     */
    protected $description = 'Get teams from api sports by season and league';

    /**
     * @throws Throwable
     */
    public function handle(ApiSportServiceInterface $apiSportService): int
    {
        $logger = Log::channel('schedule');
        $teamsDto = $apiSportService->getTeamsBySeasonAndLeague(new GetTeamsRequest(4, 2024));

        DB::beginTransaction();
        try {
            Team::upsertTeamsDto($teamsDto);
            DB::commit();
            $numberOfTeams = count($teamsDto->teams());
            $logger->info('Successfully updated ' . $numberOfTeams . ' teams');
            $this->info('Successfully updated ' . $numberOfTeams . ' teams');

            return self::SUCCESS;
        } catch (Throwable $exception) {
            DB::rollBack();
            $this->error('Error updating teams: ' . $exception->getMessage());
            $logger->error($exception->getMessage(), ['trace' => $exception->getTraceAsString()]);

            return self::FAILURE;
        }
    }
}
