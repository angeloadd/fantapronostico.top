<?php

declare(strict_types=1);

namespace App\Models\Exceptions;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

final class ClubAndNationalTeamsCannotBeTheSameException extends RuntimeException
{
    public static function forPlayerId(?int $playerId): self
    {
        return new self(
            sprintf('The national and club teams for the player %s cannot be the same', $playerId),
            Response::HTTP_CONFLICT
        );
    }
}
