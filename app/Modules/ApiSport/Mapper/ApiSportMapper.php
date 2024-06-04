<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\TeamDto;
use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Exceptions\ApiSportParsingException;
use Illuminate\Support\Facades\Log;

final class ApiSportMapper implements MapperInterface
{
    public function mapTeamsResponse(array $externalResponse): TeamsDto
    {
        return new TeamsDto(
            ...array_map(
                static fn (array $teamArray) => new TeamDto(
                    $teamArray['team']['id'],
                    $teamArray['team']['name'],
                    $teamArray['team']['code'],
                    $teamArray['team']['logo'],
                    $teamArray['team']['national'],
                ),
                $externalResponse['response']
            )
        );
    }
}
