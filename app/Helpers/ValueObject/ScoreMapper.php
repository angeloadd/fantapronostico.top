<?php

declare(strict_types=1);

namespace App\Helpers\ValueObject;

use App\Models\Player;

final class ScoreMapper
{
    public static function mapToValue(int $score): string
    {
        if (AutoGoal::check($score)) {
            return AutoGoal::toString();
        }

        if (NoGoal::check($score)) {
            return NoGoal::toString();
        }

        return Player::find($score)?->getDisplayableName();
    }
}
