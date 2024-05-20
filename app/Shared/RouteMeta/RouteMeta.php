<?php

declare(strict_types=1);

namespace App\Shared\RouteMeta;

final readonly class RouteMeta
{
    public final const LOGIN = 'login';

    public final const REGISTER = 'register';

    public final const VERIFY_EMAIL = 'verify-email';

    public final const REQUEST_PASSWORD_RESET = 'request-password-reset';

    public final const RESET_PASSWORD = 'reset-password';
}
