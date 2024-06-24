<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper\Strategy;

use App\Enums\GameStatus;
use App\Modules\ApiSport\Dto\ApiSportDto;
use App\Modules\ApiSport\Dto\GameDto;
use App\Modules\ApiSport\Dto\GamesDto;

final class GamesMapperStrategy implements MapperStrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(array $externalResponse): bool
    {
        if (array_key_exists('get', $externalResponse)) {
            return 'fixtures' === $externalResponse['get'];
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function map(array $externalResponse): ApiSportDto
    {
        return new GamesDto(
            ...array_map(
                static fn (array $item): GameDto => new GameDto(
                    $item['fixture']['id'],
                    $item['teams']['home']['id'],
                    $item['teams']['away']['id'],
                    $item['fixture']['timestamp'],
                    GameDto::getGameType($item['league']['round']),
                    in_array($item['fixture']['status']['short'], ['FT', 'AET', 'PEN']) ?
                        GameStatus::FINISHED :
                        GameStatus::NOT_STARTED,
                    (int) $externalResponse['parameters']['league'],
                ),
                $externalResponse['response']
            )
        );
    }
}
