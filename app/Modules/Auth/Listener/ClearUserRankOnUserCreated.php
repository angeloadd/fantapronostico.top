<?php

declare(strict_types=1);

namespace App\Modules\Auth\Listener;

use App\Helpers\Ranking\RankingCalculatorInterface;
use Cache;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;

final readonly class ClearUserRankOnUserCreated implements ShouldQueue
{
    public function __construct(private RankingCalculatorInterface $calculator)
    {
    }

    public function handle(Registered $event): void
    {
        Cache::forget('userRank');
        $this->calculator->get();
    }
}
