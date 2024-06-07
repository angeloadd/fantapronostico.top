<?php

declare(strict_types=1);

namespace App\Providers;

use App\Helpers\Ranking\RankingCalculator;
use App\Helpers\Ranking\RankingCalculatorInterface;
use App\Repository\Game\GameRepository;
use App\Repository\Game\GameRepositoryInterface;
use App\Repository\Prediction\PredictionRepository;
use App\Repository\Prediction\PredictionRepositoryInterface;
use App\Service\TimeManagementService;
use App\Service\TimeManagementServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PredictionRepositoryInterface::class, PredictionRepository::class);
        $this->app->bind(GameRepositoryInterface::class, GameRepository::class);
        $this->app->bind(TimeManagementServiceInterface::class, TimeManagementService::class);
        $this->app->bind(RankingCalculatorInterface::class, RankingCalculator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPagesNamespace();

        if ( ! Collection::hasMacro('sortByMulti')) {
            Collection::macro(
                'sortByMulti',
                static function (Collection $collection, array $callbacks) {
                    function internalRecursiveCallOnCollectionProvided(Collection $collection, array $callbacks): Collection
                    {
                        if (key($callbacks) === (count($callbacks) - 1)) {
                            return $collection->sortByDesc(current($callbacks));
                        }

                        return $collection->sortByDesc(current($callbacks))
                            ->groupBy(current($callbacks))
                            ->map(static function (Collection $collection) use ($callbacks) {
                                next($callbacks);

                                return internalRecursiveCallOnCollectionProvided($collection, $callbacks);
                            });
                    }

                    return internalRecursiveCallOnCollectionProvided($collection, $callbacks);
                }
            );
        }
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
                        ->last(static fn($folder) => '' !== $folder)
                );
            }
        }
    }
}
