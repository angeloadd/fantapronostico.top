<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use Illuminate\Support\Collection;

interface RankingCalculatorInterface
{
    public function get(): Collection;
}
