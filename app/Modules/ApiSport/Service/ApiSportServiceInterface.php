<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Service;

use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Request\GetTeamsRequest;

interface ApiSportServiceInterface
{
    public function getTeamsBySeasonAndLeague(GetTeamsRequest $request): TeamsDto;
}
