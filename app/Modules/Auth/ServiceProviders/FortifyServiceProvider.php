<?php

namespace App\Modules\Auth\ServiceProviders;

use App\Modules\Auth\Fortify\CreateNewUser;
use App\Modules\Auth\Fortify\ResetUserPassword;
use App\Modules\Auth\Fortify\UpdateUserPassword;
use App\Modules\Auth\Fortify\UpdateUserProfileInformation;
use App\Shared\RouteMeta\RouteMeta;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use phpDocumentor\Reflection\Types\Static_;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(static fn() => view('auth::index', ['pageName' => RouteMeta::LOGIN]));
        Fortify::registerView(static fn() => view('auth::index', ['pageName' => RouteMeta::REGISTER]));
        Fortify::requestPasswordResetLinkView(static fn() => view('auth::index', ['pageName' => RouteMeta::REQUEST_PASSWORD_RESET]));
        Fortify::resetPasswordView(static fn(Request $request) => view('auth::index', ['pageName' => RouteMeta::RESET_PASSWORD]));
        Fortify::verifyEmailView(static fn() => view('auth::index', ['pageName' => RouteMeta::VERIFY_EMAIL]));}
}
