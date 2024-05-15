<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Auth;

use App\Modules\Auth\Mail\VerificationLinkEmail;
use Illuminate\Support\Facades\Mail;
use Tests\Feature\Modules\Auth\Helpers\UserAuthTrait;
use Tests\TestCase;

final class AuthFeatureTest extends TestCase
{
    use UserAuthTrait;

    public function test_a_user_can_register_and_receives_a_mail(): void
    {
        Mail::fake();
        $response = $this->post('register', [
            'name' => self::USER_NAME,
            'email' => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
        ]);

        $response->assertRedirect('/verify-email');
        $this->assertDatabaseHas('users', [
            'name' => self::USER_NAME,
            'email' => self::USER_EMAIL,
        ]);
        Mail::assertSent(VerificationLinkEmail::class);
    }
}
