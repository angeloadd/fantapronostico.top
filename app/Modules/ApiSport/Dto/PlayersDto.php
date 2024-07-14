<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Dto;

final class PlayersDto implements ApiSportDto
{
    /**
     * @var PlayerDto[]
     */
    private array $players;

    public function __construct(PlayerDto ...$players)
    {
        $this->players = $players;
    }

    /**
     * @return PlayerDto[]
     */
    public function players(): array
    {
        return $this->players;
    }
}
