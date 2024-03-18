<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Auth\Controllers;

use App\Modules\Auth\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ViewErrorBag;
use Tests\Feature\Modules\Auth\Helpers\UserAuthTrait;
use Tests\TestCase;

final class RegisterAction extends TestCase
{
    use UserAuthTrait;

    public function test_a_user_can_register(): void
    {
        $response = $this->post('register', [
            'email' => self::USER_EMAIL,
            'name' => self::USER_NAME,
            'password' => self::USER_PASSWORD,
        ]);

        $response->assertRedirect();
        /** @var User $user */
        $user = auth()->user();
        $this->assertNotNull($user);
        $this->assertSame(self::USER_EMAIL, $user->email);
        $this->assertSame(self::USER_NAME, $user->name);
        $this->assertTrue(Hash::check(self::USER_PASSWORD, (string) $user->password));
        $this->assertNotNull($user->remember_token);
        $this->assertNull($user->email_verified_at);
    }

    public function test__user_email_must_be_unique(): void
    {
        $this->createUser();

        $this->post('register', [
            'email' => self::USER_EMAIL,
            'name' => self::USER_NAME,
            'password' => self::USER_PASSWORD,
        ]);

        /** @var ViewErrorBag $session */
        $session = session('errors');
        $this->assertSame(trans('validation.custom.email.unique'), $session->get('email')[0]);
    }
}
