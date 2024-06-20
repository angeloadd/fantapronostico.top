<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Repository;

use App\Modules\ApiSport\Dto\TeamsDto;

interface ApiSportTeamRepositoryInterface
{
    public function upsertMany(TeamsDto $teams): void;
}
