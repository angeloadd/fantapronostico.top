<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use App\Modules\League\Models\League;
use Illuminate\Support\Collection;

interface RankingCalculatorInterface
{
    public function calculate(League $league): void;

    /**
     * @return Collection<int, UserRank>
     */
    public function get(League $league): Collection;
}
