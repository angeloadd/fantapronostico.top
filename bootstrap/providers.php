<?php

use App\Modules\Auth\ServiceProviders\AuthServiceProvider;
use App\Modules\Auth\ServiceProviders\FortifyServiceProvider;
use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    FortifyServiceProvider::class,
];
