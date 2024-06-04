<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Request;

final readonly class GetTeamsRequest
{
    use HasQuery;

    public const ENDPOINT = 'teams';

    public function __construct(
        private int $league,
        private int $season
    ) {
    }
}
