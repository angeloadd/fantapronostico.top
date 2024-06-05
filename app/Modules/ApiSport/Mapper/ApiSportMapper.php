<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\TeamDto;
use App\Modules\ApiSport\Dto\TeamsDto;

final class ApiSportMapper implements MapperInterface
{
    public function mapTeamsResponse(array $externalResponse): TeamsDto
    {
        return new TeamsDto(
            $externalResponse['parameters']['league'],
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
