<?php

declare(strict_types=1);

namespace App\Modules\ApiSport;

use App\Modules\ApiSport\Client\ApiSportClient;
use App\Modules\ApiSport\Client\ApiSportClientInterface;
use App\Modules\ApiSport\Mapper\ApiSportMapper;
use App\Modules\ApiSport\Mapper\ExceptionMapperDecorator;
use App\Modules\ApiSport\Mapper\MapperInterface;
use App\Modules\ApiSport\Service\ApiSportService;
use App\Modules\ApiSport\Service\ApiSportServiceInterface;
use Illuminate\Support\ServiceProvider;

final class ApiSportServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/api-sport.php',
            'api-sport'
        );

        $this->app->bind(
            ApiSportClientInterface::class,
            static fn () => new ApiSportClient(config('api-sport.host'), config('api-sport.token'))
        );

        $this->app->bind(ApiSportServiceInterface::class, ApiSportService::class);

        $this->app->bind(MapperInterface::class, ApiSportMapper::class);
        $this->app->extend(
            MapperInterface::class,
            static fn (MapperInterface $mapper) => new ExceptionMapperDecorator($mapper)
        );
    }

    public function boot(): void
    {
    }
}
