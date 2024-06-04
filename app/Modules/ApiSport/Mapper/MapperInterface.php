<?php

namespace App\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\TeamsDto;

interface MapperInterface
{
    public function mapTeamsResponse(array $externalResponse): TeamsDto;
}
