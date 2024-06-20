<?php

declare(strict_types=1);

namespace App\Helpers\Ranking;

use Closure;
use Illuminate\Support\Collection;

final class Sorter implements SorterInterface
{
    /**
     * @var array<int, string|Closure>
     */
    private array $sorters;

    public function __construct(Closure|string ...$sorters)
    {
        $this->sorters = $sorters;
    }

    /**
     * @param Collection<UserRank $collection
     * @return Collection<UserRank
     */
    public function sortAggregate(Collection $collection): Collection
    {
        return $this->sortCollectionByCallback($collection)
            ->flatten()
            ->values();
    }

    /**
     * @param  Collection<mixed>  $collection
     * @return Collection<mixed>
     */
    private function sortCollectionByCallback(Collection $collection, int $index = 0): Collection
    {
        $currentSorter = $this->sorters[$index];

        if ($index === (count($this->sorters) - 1)) {
            return $collection->sortBy($currentSorter);
        }

        return $collection->sortByDesc($currentSorter)
            ->groupBy($currentSorter)
            ->map(fn (Collection $collection) => $this->sortCollectionByCallback($collection, $index + 1));
    }
}
