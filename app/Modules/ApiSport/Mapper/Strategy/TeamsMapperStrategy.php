<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper\Strategy;

use App\Modules\ApiSport\Dto\ApiSportDto;
use App\Modules\ApiSport\Dto\TeamDto;
use App\Modules\ApiSport\Dto\TeamsDto;

final class TeamsMapperStrategy implements MapperStrategyInterface
{
    /**
     * {@inheritDoc}
     */
    public function supports(array $externalResponse): bool
    {
        if (array_key_exists('get', $externalResponse)) {
            return 'teams' === $externalResponse['get'];
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function map(array $externalResponse): ApiSportDto
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
