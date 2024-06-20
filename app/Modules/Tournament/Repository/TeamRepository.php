<?php

declare(strict_types=1);

namespace App\Modules\Tournament\Repository;

use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Repository\ApiSportTeamRepositoryInterface;
use App\Modules\Tournament\Models\Team;

final class TeamRepository implements ApiSportTeamRepositoryInterface
{
    public function upsertMany(TeamsDto $teams): void
    {
        Team::upsertTeamsDto($teams);
    }
}
