<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\ApiSport\Dto;

use App\Modules\ApiSport\Dto\NationalDto;
use App\Modules\ApiSport\Dto\NationalsDto;
use App\Modules\ApiSport\Dto\PlayerDto;
use Tests\Unit\UnitTestCase;

final class NationalsDtoTest extends UnitTestCase
{
    public function test_add(): void
    {
        $dto = new NationalsDto();

        $this->assertEmpty($dto->nationals());

        $dto->add(new NationalDto(
            1,
            new PlayerDto(1, 'Player')
        ));

        $this->assertCount(1, $dto->nationals());
    }
}
