<?php

declare(strict_types=1);

namespace App\Modules\Auth\Service;

use App\Modules\Auth\UseCase\Shared\Exception\AuthenticatedUserCouldNotBeFoundException;
use Illuminate\Contracts\Auth\StatefulGuard;

final readonly class AuthService implements AuthServiceInterface
{
    public function __construct(private StatefulGuard $auth)
    {
    }

    public function attemptLogin(string $email, string $password): bool
    {
        return $this->auth->attempt(compact('email', 'password'), true);
    }

    public function isEmailVerified(): bool
    {
        if (null === $this->auth->user()) {
            throw AuthenticatedUserCouldNotBeFoundException::create();
        }

        return null !== $this->auth->user()->email_verified_at;
    }
}
