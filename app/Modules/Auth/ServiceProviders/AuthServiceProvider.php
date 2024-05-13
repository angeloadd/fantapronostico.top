<?php

declare(strict_types=1);

namespace App\Modules\Auth\ServiceProviders;

use App\Modules\Auth\Service\AuthService;
use App\Modules\Auth\Service\AuthServiceInterface;
use App\Modules\Auth\Service\LoginRateLimitingService;
use App\Modules\Auth\Service\RateLimiterInterface;
use App\Modules\Auth\UseCase\LoginUser\Command\LoginUserCommandHandler;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadViewsFrom((__DIR__ . '/../Views'), 'auth');

        $this->app->when(LoginUserCommandHandler::class)
            ->needs(RateLimiterInterface::class)
            ->give(LoginRateLimitingService::class);

        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    public function boot(): void
    {
        Blade::anonymousComponentPath(__DIR__ . '/../Views', 'auth');
    }
}
