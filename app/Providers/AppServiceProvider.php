<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPagesNamespace();
        Blade::anonymousComponentPath(resource_path('/views/mails'), 'mails');
    }

    private function registerPagesNamespace(): void
    {
        $foldersInPages = glob(resource_path('/views/pages') . '/**/');
        if (is_array($foldersInPages)) {
            foreach ($foldersInPages as $folder) {
                $pathSegments = array_values(
                    array_filter(
                        explode('/', $folder),
                        static fn ($string) => '' !== $string
                    )
                );

                Blade::anonymousComponentPath($folder, $pathSegments[count($pathSegments) - 1]);
            }
        }
    }
}
