<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use Illuminate\Support\Collection;

interface SorterInterface
{
    /**
     * @param  Collection<int, UserRank>  $collection
     * @return Collection<int, UserRank>
     */
    public function sortAggregate(Collection $collection): Collection;
}
