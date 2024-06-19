<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\GamesDto;
use App\Modules\ApiSport\Dto\NationalDto;
use App\Modules\ApiSport\Dto\TeamsDto;
use ErrorException;

interface MapperInterface
{
    /**
     * @param array{
     *       parameters: array{
     *           league: int
     *       },
     *       response: list<array{
     *           team: array{
     *               id: int,
     *               name: string,
     *               code: string,
     *               logo: string,
     *               national: bool
     *           }
     *       }>
     *   } $externalResponse
     *
     * @throws ErrorException
     */
    public function mapTeamsResponse(array $externalResponse): TeamsDto;

    /**
     * @param array{
     *       parameters: array{
     *           league: int
     *       },
     *       response: list<array{
     *           fixture: array{
     *               id: int,
     *               timestamp: int,
     *               status: array{
     *                   short: string
     *               }
     *           },
     *           league: array{
     *               round: string
     *           },
     *           teams: array{
     *               home: array{
     *                   id: int
     *               },
     *               away: array{
     *                   id: int
     *               },
     *           }
     *       }>
     *   } $externalResponse
     *
     * @throws ErrorException
     */
    public function mapGamesResponse(array $externalResponse): GamesDto;

    public function mapPlayersResponse(array $response): NationalDto;
}
