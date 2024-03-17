<?php

declare(strict_types=1);

namespace App\Modules\Auth\ServiceProviders;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadViewsFrom((__DIR__ . '/../Views'), 'auth');
    }

    public function boot(): void
    {
        Blade::anonymousComponentPath(__DIR__ . '/../Views', 'auth');
    }
}
