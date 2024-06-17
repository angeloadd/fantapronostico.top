<?php

namespace App\Console\Commands;

use App\Helpers\Ranking\RankingCalculatorInterface;
use App\Modules\League\Models\League;
use Illuminate\Console\Command;

class CalculateRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fp:ranking:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app(RankingCalculatorInterface::class)->calculate(League::first());
    }
}
