<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Dto;

final class TeamsDto
{
    /**
     * @var TeamDto[]
     */
    private array $teams;

    public function __construct(TeamDto ...$teams)
    {
        $this->teams = $teams;
    }

    /**
     * @return TeamDto[]
     */
    public function teams(): array
    {
        return $this->teams;
    }
}
