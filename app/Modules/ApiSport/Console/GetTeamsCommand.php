<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Console;

use App\Modules\ApiSport\Request\GetTeamsRequest;
use App\Modules\ApiSport\Service\ApiSportServiceInterface;
use App\Modules\Tournament\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Psr\Log\LoggerInterface;
use Throwable;

final class GetTeamsCommand extends Command
{
    public const EURO_2024 = 2024;

    public const EURO_API_ID = 4;

    /**
     * @var string
     */
    protected $signature = 'fp:teams:get {--L|leagueId= : League ID to get tournament api id and seson associated}';

    /**
     * @var string
     */
    protected $description = 'Get teams from api sports by season and league';

    public function handle(ApiSportServiceInterface $apiSportService, LoggerInterface $logger): int
    {
        $teamsDto = $apiSportService->getTeamsBySeasonAndLeague(new GetTeamsRequest(4, 2024));

        DB::beginTransaction();

        try {
            Team::upsertTeamsDto($teamsDto);
        } catch (Throwable $exception) {
            DB::rollBack();
            $this->error('Error updating teams: ' . $exception->getMessage());
            $logger->error($exception->getMessage(), ['trace' => $exception->getTraceAsString()]);

            return self::FAILURE;
        }

        DB::commit();

        $numberOfTeams = count($teamsDto->teams());
        $logger->info('Successfully updated ' . $numberOfTeams . ' teams');
        $this->info('Successfully updated ' . $numberOfTeams . ' teams');

        return self::SUCCESS;
    }
}
