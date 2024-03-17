<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Auth\Controllers;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Feature\Modules\Auth\Helpers\CreateUserTrait;
use Tests\TestCase;

final class LoginActionTest extends TestCase
{
    use CreateUserTrait;

    /**
     * @return iterable<array<int, array<int|string, int|string>>>
     */
    public static function badRequestProvider(): iterable
    {
        yield 'missing email and password' => [
            [],
            ['email', 'password'],
        ];
        yield 'empty email and password' => [
            [
                'email' => '',
                'password' => '',
            ],
            ['email', 'password'],
        ];
        yield 'wrong type' => [
            [
                'email' => 1,
                'password' => 12345678,
            ],
            ['email', 'password'],
        ];
    }

    public function test_a_user_can_login_and_gets_redirected_if_not_verified(): void
    {
        $this->createUser();

        $response = $this->post('api_login', [
            'email' => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
        ]);
        $response->assertRedirect('verify-email');
        $this->assertNotNull(auth()->user());
    }

    public function test_a_user_can_login_and_go_to_home(): void
    {
        $user = $this->createUser();
        $this->verifyUserEmail($user);

        $response = $this->post('api_login', [
            'email' => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
        ]);
        $response->assertRedirect('/');
        $this->assertNotNull(auth()->user());
    }

    public function test_wrong_credentials(): void
    {
        $response = $this->post('api_login', [
            'email' => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
    }

    /**
     * @param  array<int, string|int>  $input
     * @param  array<int, string|int>  $errors
     */
    #[DataProvider('badRequestProvider')]
    public function test_validation_errors(array $input, array $errors): void
    {
        $response = $this->post('api_login', $input);
        $response->assertSessionHasErrors($errors);
    }

    public function test_is_rate_limited(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('api_login', ['email' => 'ciao@example.com', 'password' => 'password']);
        }
        $response->assertSessionHasErrors('rate');
    }
}
