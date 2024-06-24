<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\ApiSport\Mapper\Strategy;

use App\Modules\ApiSport\Dto\TeamDto;
use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Mapper\Strategy\TeamsMapperStrategy;
use ErrorException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Unit\UnitTestCase;

final class TeamsMapperStrategyTest extends UnitTestCase
{
    private TeamsMapperStrategy $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new TeamsMapperStrategy();
    }

    #[DataProvider('externalResponseProvider')]
    public function test_supports_returns_true_for_teams_response_and_false_for_other_responses_or_get_prop_is_missing(array $externalResponse, bool $expected): void
    {
        $this->assertSame($expected, $this->subject->supports($externalResponse));
    }

    /**
     * @throws ErrorException
     */
    public function test_map_returns_a_correct_dto(): void
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
        $this->assertEquals($dto, $this->subject->map($response));
    }

    public static function externalResponseProvider(): iterable
    {
        yield 'has get and get is teams' => [
            [
                'get' => 'teams',
            ],
            true,
        ];

        yield 'has get and get is not teams' => [
            [
                'get' => 'other',
            ],
            false,
        ];

        yield 'has no get' => [
            [],
            false,
        ];
    }
}
