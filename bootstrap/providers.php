<?php

declare(strict_types=1);

use App\Modules\ApiSport\ApiSportServiceProvider;
use App\Modules\Auth\AuthServiceProvider;
use App\Modules\Auth\FortifyServiceProvider;
use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    FortifyServiceProvider::class,
    ApiSportServiceProvider::class,
];
