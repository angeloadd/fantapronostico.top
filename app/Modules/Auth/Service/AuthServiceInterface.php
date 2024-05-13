<?php

namespace App\Modules\Auth\Service;

interface AuthServiceInterface
{
    public function attemptLogin(string $email, string $password): bool;

    public function isEmailVerified(): bool;
}
