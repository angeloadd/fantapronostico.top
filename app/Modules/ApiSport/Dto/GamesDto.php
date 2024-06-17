<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Dto;

final class GamesDto
{
    /**
     * @var GameDto[]
     */
    private array $games;

    public function __construct(GameDto ...$games)
    {
        $this->games = $games;
    }

    /**
     * @return GameDto[]
     */
    public function games(): array
    {
        return $this->games;
    }
}
