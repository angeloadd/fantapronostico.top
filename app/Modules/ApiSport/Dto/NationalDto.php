<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Dto;

final class NationalDto implements ApiSportDto
{
    /**
     * @var PlayerDto[]
     */
    private array $players;

    public function __construct(public readonly int $nationalApiId, PlayerDto ...$players)
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
