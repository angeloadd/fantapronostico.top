<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Service;

use App\Modules\ApiSport\Client\ApiSportClientInterface;
use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Mapper\TeamMapper;
use App\Modules\ApiSport\Request\GetTeamsRequest;

final readonly class ApiSportService implements ApiSportServiceInterface
{
    public function __construct(private ApiSportClientInterface $apiSportClient)
    {
    }

    public function getTeamsBySeasonAndLeague(GetTeamsRequest $request): TeamsDto
    {
        return TeamMapper::map($this->apiSportClient->get($request::ENDPOINT, $request->toQuery()));
    }
}
