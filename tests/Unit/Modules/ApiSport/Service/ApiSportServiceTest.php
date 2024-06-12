<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\ApiSport\Service;

use App\Modules\ApiSport\Client\ApiSportClientInterface;
use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Mapper\MapperInterface;
use App\Modules\ApiSport\Request\GetTeamsRequest;
use App\Modules\ApiSport\Service\ApiSportService;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Unit\UnitTestCase;

final class ApiSportServiceTest extends UnitTestCase
{
    private ApiSportClientInterface&MockObject $client;

    private MapperInterface&MockObject $mapper;

    private ApiSportService $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createMock(ApiSportClientInterface::class);
        $this->mapper = $this->createMock(MapperInterface::class);
        $this->subject = new ApiSportService($this->client, $this->mapper);
    }

    public function test_GetTeamsBySeasonAndLeague_returns_a_dto(): void
    {
        $response = ['parameters' => ['league' => 1], 'response' => ['teams' => ['ok']]];
        $this->client->expects($this->once())->method('get')
            ->with('teams', ['league' => 1, 'season' => 2050])
            ->willReturn($response);
        $this->mapper->expects($this->once())->method('mapTeamsResponse')
            ->with($response)
            ->willReturn(new TeamsDto($response['parameters']['league']));
        $this->subject->getTeamsBySeasonAndLeague(new GetTeamsRequest(1, 2050));
    }
}
