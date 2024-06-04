<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\TeamDto;
use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Exceptions\ApiSportParsingException;
use App\Modules\ApiSport\Mapper\ApiSportMapper;
use App\Modules\ApiSport\Mapper\ExceptionMapperDecorator;
use Tests\Unit\UnitTestCase;

final class ExceptionMapperDecoratorTest extends UnitTestCase
{
    public function test_mapTeamsResponse_returns_a_dto(): void
    {
        $teamDto = new TeamDto(1, 'name', 'code', 'logo', false);
        $teamDto2 = new TeamDto(2, 'name', 'code', 'logo', true);
        $dto = new TeamsDto($teamDto, $teamDto2);
        $response = [
            'response' => [
                ['team' => ['id' => $teamDto->apiId, 'name' => $teamDto->name, 'code' => $teamDto->code, 'logo' => $teamDto->logo, 'national' => $teamDto->isNational]],
                ['team' => ['id' => $teamDto2->apiId, 'name' => $teamDto2->name, 'code' => $teamDto2->code, 'logo' => $teamDto2->logo, 'national' => $teamDto2->isNational]],
            ],
        ];
        $this->assertEquals($dto, (new ExceptionMapperDecorator(new ApiSportMapper()))->mapTeamsResponse($response));
    }
    public function test_mapTeamsResponse_throws_for_unexpected_response(): void
    {
        $this->expectException(ApiSportParsingException::class);
        (new ExceptionMapperDecorator(new ApiSportMapper()))->mapTeamsResponse(['invalid']);
    }
}
