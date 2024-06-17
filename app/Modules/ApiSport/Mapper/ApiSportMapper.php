<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper;

use App\Enums\GameStatus;
use App\Modules\ApiSport\Dto\GameDto;
use App\Modules\ApiSport\Dto\GamesDto;
use App\Modules\ApiSport\Dto\TeamDto;
use App\Modules\ApiSport\Dto\TeamsDto;
use ErrorException;

final class ApiSportMapper implements MapperInterface
{
    /**
     * @param array{
     *     parameters: array{
     *         league: int
     *     },
     *     response: list<array{
     *         team: array{
     *             id: int,
     *             name: string,
     *             code: string,
     *             logo: string,
     *             national: bool
     *         }
     *     }>
     * } $externalResponse
     *
     * @throws ErrorException
     *
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

    /**
     * @param array{
     *     parameters: array{
     *         league: int
     *     },
     *     response: list<array{
     *         fixture: array{
     *             id: int,
     *             timestamp: int,
     *             status: array{
     *                 short: string
     *             }
     *         },
     *         league: array{
     *             round: string
     *         },
     *         teams: array{
     *             home: array{
     *                 id: int
     *             },
     *             away: array{
     *                 id: int
     *             },
     *         }
     *     }>
     * } $externalResponse
     *
     * @throws ErrorException
     *
     */
    public function mapGamesResponse(array $externalResponse): GamesDto
    {
        return new GamesDto(
            ...array_map(
                static fn (array $item): GameDto => new GameDto(
                    $item['fixture']['id'],
                    $item['teams']['home']['id'],
                    $item['teams']['away']['id'],
                    $item['fixture']['timestamp'],
                    GameDto::getGameType($item['league']['round']),
                    in_array($item['fixture']['status']['short'], ['FT', 'AET', 'PEN']) ?
                        GameStatus::FINISHED :
                        GameStatus::NOT_STARTED,
                    (int) $externalResponse['parameters']['league'],
                ),
                $externalResponse['response']
            )
        );
    }
}
