<?php

declare(strict_types=1);

$serviceProviders = [];

return [
    App\Providers\AppServiceProvider::class,
    App\Modules\Auth\ServiceProviders\FortifyServiceProvider::class,
    App\Modules\Auth\ServiceProviders\AuthServiceProvider::class,
];
