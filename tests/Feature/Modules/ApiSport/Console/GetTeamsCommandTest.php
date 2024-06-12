<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\ApiSport\Console;

use App\Models\Tournament;
use Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\PendingCommand;
use Tests\TestCase;

final class GetTeamsCommandTest extends TestCase
{
    private const SECOND_DTO = [
        'id' => 2,
        'is_national' => false,
        'code' => 'AFR',
        'name' => 'Country',
        'logo' => 'Logo 2',
    ];

    private const FIRST_DTO = [
        'id' => 1,
        'is_national' => true,
        'code' => 'CNR',
        'name' => 'Nation',
        'logo' => 'Logo 1',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        if ( ! Config::has('api-sport.host')) {
            $this->fail('ApiSport host not configured');
        }
        Config::set('api-sport.host', 'api-sport-host');
        Http::fake([
            'api-sport-host/*' => Http::response($this->getResponse()),
        ]);

        Tournament::factory()->euro()->create();
    }

    public function test_handle(): void
    {
        /**
         * @var PendingCommand $pendingCommand
         */
        $pendingCommand = $this->artisan('fp:teams:get');
        $pendingCommand
            ->expectsOutput('Successfully updated 2 teams')
            ->assertOk()
            ->run();

        $this->assertDatabaseHas('teams', self::FIRST_DTO);
        $this->assertDatabaseHas('teams', self::SECOND_DTO);
    }

    /**
     * @return array{parameters: array{league: int}, response: array{array{team: array{id: int, national: bool, code: string, name: string, logo: string}}}}
     */
    private function getResponse(): array
    {
        return [
            'parameters' => ['league' => 1],
            'response' => [
                [
                    'team' => [
                        'id' => 1,
                        'national' => true,
                        'code' => 'CNR',
                        'name' => 'Nation',
                        'logo' => 'Logo 1',
                    ],
                ],
                [
                    'team' => [
                        'id' => 2,
                        'national' => false,
                        'code' => 'AFR',
                        'name' => 'Country',
                        'logo' => 'Logo 2',
                    ],
                ],
            ],
        ];
    }
}
