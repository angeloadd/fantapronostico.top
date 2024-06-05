<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Service;

use App\Modules\ApiSport\Client\ApiSportClientInterface;
use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Mapper\MapperInterface;
use App\Modules\ApiSport\Request\GetTeamsRequest;

final readonly class ApiSportService implements ApiSportServiceInterface
{
    public function __construct(
        private ApiSportClientInterface $apiSportClient,
        private MapperInterface $mapper
    ) {
    }

    public function getTeamsBySeasonAndLeague(GetTeamsRequest $request): TeamsDto
    {
        $response = $this->apiSportClient->get($request::ENDPOINT, $request->toQuery());

        return $this->mapper->mapTeamsResponse($response);
    }
}
