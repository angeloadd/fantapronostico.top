<?php

declare(strict_types=1);

namespace App\Modules\ApiSport;

use App\Modules\ApiSport\Client\ApiSportClient;
use App\Modules\ApiSport\Client\ApiSportClientInterface;
use App\Modules\ApiSport\Console\GetGamesCommand;
use App\Modules\ApiSport\Console\GetTeamsCommand;
use App\Modules\ApiSport\Mapper\ApiSportMapper;
use App\Modules\ApiSport\Mapper\ExceptionMapperDecorator;
use App\Modules\ApiSport\Mapper\MapperInterface;
use App\Modules\ApiSport\Service\ApiSportService;
use App\Modules\ApiSport\Service\ApiSportServiceInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

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
            static fn () => new ApiSportClient((string) config('api-sport.host'), (string) config('api-sport.token'))
        );

        $this->app->bind(ApiSportServiceInterface::class, ApiSportService::class);
        $this->app->bind(MapperInterface::class, ApiSportMapper::class);
        $this->app->extend(
            MapperInterface::class,
            static fn (MapperInterface $mapper) => new ExceptionMapperDecorator($mapper, Log::channel('schedule'))
        );

        $this->provideScheduleLogger();
    }

    public function boot(): void
    {
    }

    private function provideScheduleLogger(): void
    {
        $this->app->bindMethod(
            [GetTeamsCommand::class, 'handle'],
            static fn (GetTeamsCommand $command, Application $app) => $command->handle(
                $app->make(ApiSportServiceInterface::class),
                Log::channel('schedule')
            )
        );
        $this->app->bindMethod(
            [GetGamesCommand::class, 'handle'],
            static fn (GetGamesCommand $command, Application $app) => $command->handle(
                $app->make(ApiSportServiceInterface::class),
                Log::channel('schedule')
            )
        );

        $this->app->when(ExceptionMapperDecorator::class)
            ->needs(LoggerInterface::class)
            ->give(static fn (Application $app) => Log::channel('schedule'));

    }
}
