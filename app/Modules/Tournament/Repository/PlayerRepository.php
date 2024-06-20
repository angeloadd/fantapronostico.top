<?php

declare(strict_types=1);

namespace App\Modules\Tournament\Repository;

use App\Models\Player;
use App\Modules\ApiSport\Dto\NationalsDto;
use App\Modules\ApiSport\Repository\ApiSportPlayerRepositoryInterface;

final class PlayerRepository implements ApiSportPlayerRepositoryInterface
{
    public function upsertManyByNational(NationalsDto $nationals): void
    {
        Player::upsertMany($nationals);
    }
}
