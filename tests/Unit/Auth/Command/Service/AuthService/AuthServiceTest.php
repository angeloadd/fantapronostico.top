<?php

declare(strict_types=1);

namespace Tests\Unit\Auth\Command\Service\AuthService;

use App\Modules\Auth\Service\AuthService;
use DateTimeImmutable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

final class AuthServiceTest extends TestCase
{
    private StatefulGuard&MockObject $auth;

    private Authenticatable&Stub $user;

    private AuthService $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->auth = $this->createMock(StatefulGuard::class);
        $this->user = $this->createStub(Authenticatable::class);
        $this->subject = new AuthService($this->auth);
    }

    public function test_attemptLogin_should_return_true_when_login_is_successful(): void
    {
        $this->auth->method('attempt')->willReturn(true);
        $this->assertTrue($this->subject->attemptLogin('email', 'password'));
    }
    public function test_attemptLogin_should_return_false_when_login_fails(): void
    {
        $this->auth->method('attempt')->willReturn(false);
        $this->assertFalse($this->subject->attemptLogin('email', 'password'));
    }

    public function test_isEmailVerified_should_return_true_when_email_is_verified(): void
    {
        $this->auth->method('user')->willReturn($this->user);
        $this->user->email_verified_at = new DateTimeImmutable();
        $this->assertTrue($this->subject->isEmailVerified());
    }
    public function test_isEmailVerified_should_return_false_when_email_is_not_verified(): void
    {
        $this->auth->method('user')->willReturn($this->user);
        $this->assertFalse($this->subject->isEmailVerified());
    }
}
