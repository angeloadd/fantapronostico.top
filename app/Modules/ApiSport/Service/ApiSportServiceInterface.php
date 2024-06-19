<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Service;

use App\Modules\ApiSport\Dto\GamesDto;
use App\Modules\ApiSport\Dto\NationalsDto;
use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Exceptions\InvalidApisportTokenException;
use App\Modules\ApiSport\Request\GetGamesRequest;
use App\Modules\ApiSport\Request\GetPlayersByNationalRequest;
use App\Modules\ApiSport\Request\GetTeamsRequest;
use ErrorException;
use Illuminate\Http\Client\ConnectionException;

interface ApiSportServiceInterface
{
    /**
     * @throws InvalidApisportTokenException
     * @throws ConnectionException
     * @throws ErrorException
     */
    public function getTeamsBySeasonAndLeague(GetTeamsRequest $request): TeamsDto;

    public function getGamesBySeasonAndLeague(GetGamesRequest $request): GamesDto;

    /**
     * @param  GetPlayersByNationalRequest[]  $requests
     *
     * @throws ConnectionException
     * @throws InvalidApisportTokenException
     * @throws ErrorException
     */
    public function getPlayersByNational(array $requests, int $rateInSeconds = 0): NationalsDto;
}
