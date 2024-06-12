<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\TeamDto;
use App\Modules\ApiSport\Dto\TeamsDto;
use ErrorException;

final class ApiSportMapper implements MapperInterface
{
    /**
     * @throws ErrorException
     */
    public function mapTeamsResponse(array $externalResponse): TeamsDto
    {
        return new TeamsDto(
            (int) $externalResponse['parameters']['league'],
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
