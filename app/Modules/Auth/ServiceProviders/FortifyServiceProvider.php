<?php

declare(strict_types=1);

namespace App\Modules\Auth\ServiceProviders;

use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

final class FortifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    }
}
