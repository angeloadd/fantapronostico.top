<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Service;

use App\Modules\ApiSport\Client\ApiSportClientInterface;
use App\Modules\ApiSport\Dto\GamesDto;
use App\Modules\ApiSport\Dto\NationalsDto;
use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Exceptions\InvalidApisportTokenException;
use App\Modules\ApiSport\Mapper\MapperInterface;
use App\Modules\ApiSport\Request\GetGamesRequest;
use App\Modules\ApiSport\Request\GetPlayersByNationalRequest;
use App\Modules\ApiSport\Request\GetTeamsRequest;
use ErrorException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Sleep;

final readonly class ApiSportService implements ApiSportServiceInterface
{
    public function __construct(
        private ApiSportClientInterface $apiSportClient,
        private MapperInterface $mapper,
    ) {
    }

    /**
     * @throws InvalidApisportTokenException
     * @throws ConnectionException
     * @throws ErrorException
     */
    public function getTeamsBySeasonAndLeague(GetTeamsRequest $request): TeamsDto
    {
        /**
         * @var array{
         *        parameters: array{
         *            league: int
         *        },
         *        response: list<array{
         *            team: array{
         *                id: int,
         *                name: string,
         *                code: string,
         *                logo: string,
         *                national: bool
         *            }
         *        }>
         *    } $response
         */
        $response = $this->apiSportClient->get($request::ENDPOINT, $request->toQuery());

        return $this->mapper->mapTeamsResponse($response);
    }

    /**
     * @throws InvalidApisportTokenException
     * @throws ErrorException
     * @throws ConnectionException
     */
    public function getGamesBySeasonAndLeague(GetGamesRequest $request): GamesDto
    {
        /**
         * @var array{
         *        parameters: array{
         *            league: int
         *        },
         *        response: list<array{
         *            fixture: array{
         *                id: int,
         *                timestamp: int,
         *                status: array{
         *                    short: string
         *                }
         *            },
         *            league: array{
         *                round: string
         *            },
         *            teams: array{
         *                home: array{
         *                    id: int
         *                },
         *                away: array{
         *                    id: int
         *                },
         *            }
         *        }>
         *    } $response
         */
        $response = $this->apiSportClient->get($request::ENDPOINT, $request->toQuery());

        return $this->mapper->mapGamesResponse($response);
    }

    /**
     * @param  GetPlayersByNationalRequest[]  $requests
     *
     * @throws ConnectionException
     * @throws InvalidApisportTokenException
     * @throws ErrorException
     */
    public function getPlayersByNational(array $requests, int $rateInSeconds = 0): NationalsDto
    {
        $nationals = new NationalsDto();
        foreach ($requests as $request) {
            $response = $this->apiSportClient->get($request::ENDPOINT, $request->toQuery());

            $nationals->add($this->mapper->mapPlayersResponse($response));

            if ($rateInSeconds > 0) {
                Sleep::for($rateInSeconds)->seconds();
            }
        }

        return $nationals;
    }
}
