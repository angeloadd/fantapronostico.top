<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper\Strategy;

use App\Modules\ApiSport\Dto\ApiSportDto;
use App\Modules\ApiSport\Dto\PlayerDto;
use App\Modules\ApiSport\Dto\PlayersDto;
use App\Modules\ApiSport\Mapper\Strategy\MapperStrategyInterface;

final class TopScorersMapperStrategy implements MapperStrategyInterface
{
    /**
     * @inheritDoc
     */
    public function supports(array $externalResponse): bool
    {
        return $externalResponse['get'] === 'players/topscorers';
    }

    /**
     * @inheritDoc
     */
    public function map(array $externalResponse): ApiSportDto
    {
        $players = [];
        $maxGoals = 0;

        foreach ($externalResponse['response'] as $player) {
            if($player['statistics']['goals']['total'] < $maxGoals) {
                break;
            }

            $maxGoals = max($player['statistics']['goals']['total'], $maxGoals);

            $players[] = new PlayersDto(
                $players['player']['id'],
                $players['player']['name'],
            );

        }
        return new PlayersDto(...$players);
    }
}
