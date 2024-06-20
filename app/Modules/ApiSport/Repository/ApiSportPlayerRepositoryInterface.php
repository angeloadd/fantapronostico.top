<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Repository;

use App\Modules\ApiSport\Dto\NationalsDto;

interface ApiSportPlayerRepositoryInterface
{
    public function upsertManyByNational(NationalsDto $nationals): void;
}
