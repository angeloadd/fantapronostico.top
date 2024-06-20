<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Repository;

use App\Modules\ApiSport\Dto\GamesDto;

interface ApiSportGameRepositoryInterface
{
    public function upsertMany(GamesDto $games): void;
}
