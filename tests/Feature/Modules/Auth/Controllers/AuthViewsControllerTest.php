<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Auth\Controllers;

use Tests\Feature\Modules\Auth\Helpers\UserAuthTrait;
use Tests\TestCase;

final class AuthViewsControllerTest extends TestCase
{
    use UserAuthTrait;

    public const LOGIN_ENDPOINT = '/login';
    public const VERIFY_EMAIL_ENDPOINT = '/verify-email';
    public const REGISTER_ENDPOINT = '/register';

    public function test_a_user_can_visit_login_if_not_authenticated(): void
    {
        $this->get(self::LOGIN_ENDPOINT)->assertOk()->assertSee('Accedi');
    }

    public function test_a_user_can_visit_register_if_not_authenticated(): void
    {
        $this->get(self::REGISTER_ENDPOINT)->assertOk()->assertSee('Accedi');
    }

    public function test_a_user_can_visit_verify_email_if_authenticated_and_not_verified(): void
    {
        $user = $this->loginUser();
        $this->get(self::VERIFY_EMAIL_ENDPOINT)->assertOk()->assertSee($user->name);
    }

    public function test_a_user_gets_redirected_if_on_verify_email_and_not_authenticated(): void
    {
        $this->get(self::VERIFY_EMAIL_ENDPOINT)
            ->assertRedirect($this->makeTestUrl(self::LOGIN_ENDPOINT));
    }

    public function test_a_user_cannot_see_login_or_register_if_authenticated(): void
    {
        $this->loginUser();

        $this->get(self::LOGIN_ENDPOINT)->assertRedirect($this->makeTestUrl());
        $this->get(self::REGISTER_ENDPOINT)->assertRedirect($this->makeTestUrl());
    }

    public function test_a_user_gets_redirected_if_visiting_verify_email_with_email_verified(): void
    {
        $user = $this->loginUser();
        $this->verifyUserEmail($user);

        $this->get(self::VERIFY_EMAIL_ENDPOINT)->assertRedirect($this->makeTestUrl());
    }
}
