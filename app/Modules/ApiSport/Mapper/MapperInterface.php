<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\TeamsDto;
use ErrorException;

interface MapperInterface
{
    /**
     * @throws ErrorException
     */
    public function mapTeamsResponse(array $externalResponse): TeamsDto;
}
