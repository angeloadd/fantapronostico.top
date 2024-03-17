<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Auth\Models;

use App\Modules\Auth\Models\User;
use DateTimeImmutable;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

final class UserTest extends TestCase
{
    public function test_a_user_can_be_created(): void
    {
        $attributes = [
            'name' => 'john',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('123123123'),
            'email_verified_at' => new DateTimeImmutable(),
        ];
        $user = new User();

        $user->name = $attributes['name'];
        $user->email = $attributes['email'];
        $user->password = $attributes['password'];
        $user->email_verified_at = $attributes['email_verified_at'];

        $user->save();

        $this->assertDatabaseHas('users', $attributes);
    }
}
