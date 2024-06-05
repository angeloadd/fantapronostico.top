<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\TeamsDto;

interface MapperInterface
{
    public function mapTeamsResponse(array $externalResponse): TeamsDto;
}
