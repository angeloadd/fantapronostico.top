<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use Closure;
use Illuminate\Support\Collection;

final class Sorter
{
    /**
     * @param  Closure[]  $sorters
     */
    public function __invoke(Collection $collection, array $sorters): Collection
    {
        return $this->sortCollectionByCallback($collection, $sorters, 0)->flatten()->values();
    }

    private function sortCollectionByCallback(Collection $collection, array $sorters, int $index): Collection
    {
        $currentSorter = $sorters[$index];

        if ($index === (count($sorters) - 1)) {
            return $collection->sortBy($currentSorter);
        }

        return $collection->sortByDesc($currentSorter)
            ->groupBy($currentSorter)
            ->map(fn (Collection $collection) => $this->sortCollectionByCallback($collection, $sorters, $index + 1));
    }
}
