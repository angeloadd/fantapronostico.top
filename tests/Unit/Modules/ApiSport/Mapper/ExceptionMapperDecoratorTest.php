<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\TeamDto;
use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Exceptions\ApiSportParsingException;
use App\Modules\ApiSport\Mapper\ApiSportMapper;
use App\Modules\ApiSport\Mapper\ExceptionMapperDecorator;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Tests\Unit\UnitTestCase;

final class ExceptionMapperDecoratorTest extends UnitTestCase
{
    private ExceptionMapperDecorator $subject;

    private LoggerInterface&MockObject $logger;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->subject = new ExceptionMapperDecorator(new ApiSportMapper(), $this->logger);
    }

    public function test_mapTeamsResponse_returns_a_dto(): void
    {
        $teamDto = new TeamDto(1, 'name', 'code', 'logo', false);
        $teamDto2 = new TeamDto(2, 'name', 'code', 'logo', true);
        $dto = new TeamsDto(4, $teamDto, $teamDto2);
        $response = [
            'parameters' => ['league' => 4],
            'response' => [
                ['team' => ['id' => $teamDto->apiId, 'name' => $teamDto->name, 'code' => $teamDto->code, 'logo' => $teamDto->logo, 'national' => $teamDto->isNational]],
                ['team' => ['id' => $teamDto2->apiId, 'name' => $teamDto2->name, 'code' => $teamDto2->code, 'logo' => $teamDto2->logo, 'national' => $teamDto2->isNational]],
            ],
        ];
        $this->assertEquals($dto, $this->subject->mapTeamsResponse($response));
    }

    public function test_mapTeamsResponse_throws_for_unexpected_response(): void
    {
        $this->expectException(ApiSportParsingException::class);
        $this->subject->mapTeamsResponse(['invalid']);
    }
}
