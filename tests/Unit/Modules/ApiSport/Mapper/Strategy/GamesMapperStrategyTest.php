<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\ApiSport\Mapper\Strategy;

use App\Enums\GameStatus;
use App\Modules\ApiSport\Dto\GameDto;
use App\Modules\ApiSport\Dto\GamesDto;
use App\Modules\ApiSport\Dto\TeamDto;
use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Mapper\Strategy\GamesMapperStrategy;
use App\Modules\ApiSport\Mapper\Strategy\TeamsMapperStrategy;
use ErrorException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Unit\UnitTestCase;

final class GamesMapperStrategyTest extends UnitTestCase
{
    private GamesMapperStrategy $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new GamesMapperStrategy();
    }

    #[DataProvider('externalResponseProvider')]
    public function test_supports_returns_true_for_fixtures_response_and_false_for_other_responses_or_get_prop_is_missing(array $externalResponse, bool $expected): void
    {
        $this->assertSame($expected, $this->subject->supports($externalResponse));
    }

    /**
     * @throws ErrorException
     */
    public function test_map_returns_a_correct_dto(): void
    {
        $gameDto = new GameDto(1, 1, 2, 123123123, 'group', GameStatus::FINISHED, 4);
        $gameDto2 = new GameDto(2, 3, 4, 321321321, 'round', GameStatus::NOT_STARTED, 4);
        $dto = new GamesDto($gameDto, $gameDto2);
        $response = [
            'parameters' => ['league' => 4, 'season' => 2024],
            'response' => [
                [
                    'fixture' => [
                        'id' => 1,
                        'timestamp' => 123123123,
                        'status' => ['short' => 'FT'],
                    ],
                    'teams' => [
                        'home' => ["id" => 1],
                        'away' => ["id" => 2],
                    ],
                    'league' => [
                        'round' => 'Group E',
                    ]
                ],
                [
                    'fixture' => [
                        'id' => 2,
                        'timestamp' => 321321321,
                        'status' => ['short' => 'NS'],
                    ],
                    'teams' => [
                        'home' => ["id" => 3],
                        'away' => ["id" => 4],
                    ],
                    'league' => [
                        'round' => 'Round of sixteen',
                    ]
                ],
            ],
        ];
        $this->assertEquals($dto, $this->subject->map($response));
    }

    public static function externalResponseProvider(): iterable
    {
        yield 'has get and get is fixtures' => [
            [
                'get' => 'fixtures',
            ],
            true,
        ];

        yield 'has get and get is not fixtures' => [
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
