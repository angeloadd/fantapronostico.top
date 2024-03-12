<?php

declare(strict_types=1);

namespace App\Models\Exceptions;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

final class ClubTeamCannotBeNationalException extends RuntimeException
{
    public static function forPlayerId(?int $playerId): self
    {
        return new self(
            sprintf('Club team for player %s cannot be national', $playerId),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
