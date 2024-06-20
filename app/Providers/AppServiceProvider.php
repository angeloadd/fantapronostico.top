<?php

declare(strict_types=1);

namespace App\Providers;

use App\Helpers\Ranking\RankingCalculator;
use App\Helpers\Ranking\RankingCalculatorInterface;
use App\Helpers\Ranking\Sorter;
use App\Helpers\Ranking\SorterInterface;
use App\Modules\League\Models\League;
use App\Repository\Game\GameRepository;
use App\Repository\Game\GameRepositoryInterface;
use App\Repository\Prediction\PredictionRepository;
use App\Repository\Prediction\PredictionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PredictionRepositoryInterface::class, PredictionRepository::class);
        $this->app->bind(GameRepositoryInterface::class, GameRepository::class);
        $this->app->bind(RankingCalculatorInterface::class, RankingCalculator::class);
        $this->app->bind(SorterInterface::class, static fn () => new Sorter(
            'total',
            'numberOfResults',
            'numberOfScorers',
            'numberOfSigns',
            'finalBetTotal',
            'finalBetTimestamp',
            'userName',
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPagesNamespace();

        $this->registerRequestMacro();
    }

    private function registerPagesNamespace(): void
    {
        $foldersInPages = glob(resource_path('/views/pages') . '/**/');
        if (is_array($foldersInPages)) {
            foreach ($foldersInPages as $folder) {
                Blade::anonymousComponentPath(
                    $folder,
                    str($folder)
                        ->explode('/')
                        ->last(static fn ($folder) => '' !== $folder)
                );
            }
        }
    }

    private function registerRequestMacro(): void
    {
        if ( ! Request::hasMacro('getCurrentLeague')) {
            Request::macro('getCurrentLeague', function (): League {
                $league = request()->league;
                if ( ! $league instanceof League) {
                    throw new InvalidArgumentException('Current league cannot be retrieved');
                }

                return $league;
            });
        }
    }
}
