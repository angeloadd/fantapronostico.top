<?php

namespace App\Modules\Auth\Listener;

use App\Helpers\Ranking\RankingCalculatorInterface;
use Cache;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;

readonly class ClearUserRankOnUserCreated implements ShouldQueue
{
    public function __construct(private RankingCalculatorInterface $calculator)
    {
    }

    public function handle(Registered $event): void
    {
        Cache::forget('UserRank');
        $this->calculator->get();
    }
}
