<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\ApiSport\Mapper\Strategy;

use App\Modules\ApiSport\Dto\NationalDto;
use App\Modules\ApiSport\Dto\PlayerDto;
use App\Modules\ApiSport\Mapper\Strategy\NationalsMapperStrategy;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Unit\UnitTestCase;

final class NationalsMapperStrategyTest extends UnitTestCase
{
    private NationalsMapperStrategy $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new NationalsMapperStrategy();
    }

    public static function externalResponseProvider(): iterable
    {
        yield 'has get and get is players by national team' => [
            [
                'get' => 'players/squads',
            ],
            true,
        ];

        yield 'has get and get is not players by national team' => [
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

    #[DataProvider('externalResponseProvider')]
    public function test_supports_returns_true_for_players_squads_response_and_false_for_other_responses_or_get_prop_is_missing(array $externalResponse, bool $expected): void
    {
        $this->assertSame($expected, $this->subject->supports($externalResponse));
    }

    public function test_map_returns_a_correct_dto(): void
    {
        $playerDto = new PlayerDto(1, 'Player One');
        $playerDto2 = new PlayerDto(2, 'Player Two');
        $playerDto3 = new PlayerDto(3, 'Player Three');
        $dto = new NationalDto(1, $playerDto, $playerDto2, $playerDto3);

        $response = [
            'response' => [
                [
                    'team' => [
                        'id' => 1,
                    ],
                    'players' => [
                        ['id' => 1, 'name' => 'Player One'],
                        ['id' => 2, 'name' => 'Player Two'],
                        ['id' => 3, 'name' => 'Player Three'],
                    ],
                ],
            ],
        ];

        $this->assertEquals($dto, $this->subject->map($response));
    }
}
