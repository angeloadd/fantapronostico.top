<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Mail\EmailVerificationLink;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

final class AuthFeatureTest extends TestCase
{
    public function test_a_user_can_register_and_receives_a_mail(): void
    {
        Mail::fake();
        $response = $this->post('api_register', [
            'name' => self::USER_NAME,
            'email' => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
        ]);

        $response->assertRedirect('/verify-email');
        $this->assertDatabaseHas('users', [
            'name' => self::USER_NAME,
            'email' => self::USER_EMAIL,
        ]);
        Mail::assertSent(EmailVerificationLink::class);
    }
}
