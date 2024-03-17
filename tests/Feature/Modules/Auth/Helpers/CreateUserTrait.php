<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Auth\Helpers;

use App\Modules\Auth\Models\User;
use DateTimeImmutable;
use Illuminate\Support\Facades\Hash;

trait CreateUserTrait
{
    private const USER_NAME = 'john';

    private const USER_EMAIL = 'john.doe@example.com';

    private const USER_PASSWORD = '123123123';

    private function createUser(?string $email = null, ?string $name = null, ?string $password = null): User
    {
        return User::create([
            'name' => $name ?? self::USER_NAME,
            'email' => $email ?? self::USER_EMAIL,
            'password' => Hash::make($password ?? self::USER_PASSWORD),
        ]);
    }

    private function verifyUserEmail(User $user): User
    {
        $user->email_verified_at = new DateTimeImmutable();

        $user->save();

        return $user;
    }
}
