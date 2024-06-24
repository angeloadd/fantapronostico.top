<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper\Strategy;

use App\Modules\ApiSport\Dto\ApiSportDto;
use App\Modules\ApiSport\Dto\NationalDto;
use App\Modules\ApiSport\Dto\PlayerDto;

final class NationalsMapperStrategy implements MapperStrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(array $externalResponse): bool
    {
        if (array_key_exists('get', $externalResponse)) {
            return 'players/squads' === $externalResponse['get'];
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function map(array $externalResponse): ApiSportDto
    {
        return new NationalDto(
            (int) $externalResponse['response'][0]['team']['id'],
            ...array_map(
                static fn (array $player) => new PlayerDto($player['id'], $player['name']),
                $externalResponse['response'][0]['players']
            )
        );
    }
}
