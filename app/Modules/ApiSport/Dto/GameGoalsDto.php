<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Dto;

final class GameGoalsDto implements ApiSportDto
{
    /**
     * @var GameGoalDto[]
     */
    private array $gameGoals;

    public function __construct(GameGoalDto ...$gameGoals)
    {
        $this->gameGoals = $gameGoals;
    }

    public function add(GameGoalDto $gameGoal): self
    {
        $this->gameGoals[] = $gameGoal;

        return $this;
    }

    /**
     * @return GameGoalsDto[]
     */
    public function gameGoals(): array
    {
        return $this->gameGoals;
    }
}
