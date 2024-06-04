<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Console;

use App\Models\Team;
use App\Modules\ApiSport\Request\GetTeamsRequest;
use App\Modules\ApiSport\Service\ApiSportServiceInterface;
use Illuminate\Console\Command;

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

    public function handle(ApiSportServiceInterface $apiSportService): int
    {
        $teamsDto = $apiSportService->getTeamsBySeasonAndLeague(new GetTeamsRequest(4, 2024));

        Team::upsertTeamsDto($teamsDto);

        return self::SUCCESS;
    }
}
