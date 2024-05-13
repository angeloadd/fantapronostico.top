<?php

declare(strict_types=1);

namespace Tests\Unit\Auth\Command\LoginUser;

use App\Modules\Auth\Service\AuthServiceInterface;
use App\Modules\Auth\Service\RateLimiterInterface;
use App\Modules\Auth\UseCase\LoginUser\Command\LoginUserCommand;
use App\Modules\Auth\UseCase\LoginUser\Command\LoginUserCommandHandler;
use App\Modules\Auth\UseCase\LoginUser\Exception\EmailNotVerifiedException;
use App\Modules\Auth\UseCase\LoginUser\Exception\LoginAttemptFailedException;
use App\Modules\Auth\UseCase\LoginUser\Exception\RateLimitExceededException;
use Illuminate\Contracts\Session\Session;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class LoginUserCommandHandlerTest extends TestCase
{
    private RateLimiterInterface&MockObject $rateLimiter;

    private LoginUserCommandHandler $subject;

    private AuthServiceInterface&MockObject $authService;


    private LoginUserCommand $command;

    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new LoginUserCommand('email', 'password');

        $this->rateLimiter = $this->createMock(RateLimiterInterface::class);
        $this->authService = $this->createMock(AuthServiceInterface::class);

        $this->subject = new LoginUserCommandHandler(
            $this->rateLimiter,
            $this->authService,
            $this->createStub(Session::class)
        );
    }

    public function test_handle_logins_a_user(): void
    {
        $this->rateLimiter->method('tooManyAttempts')->willReturn(false);
        $this->authService->method('attemptLogin')
            ->with('email','password')
            ->willReturn(true);
        $this->authService->method('isEmailVerified')
            ->willReturn(true);
        $this->assertNull(
            $this->subject->handle($this->command)
        );
    }

    public function test_handle_throws_an_exception_if_rate_limit_is_exceeded(): void
    {
        $this->rateLimiter->method('tooManyAttempts')->willReturn(true);
        $this->expectException(RateLimitExceededException::class);
        $this->command = new LoginUserCommand('email', 'password');
        $this->subject->handle($this->command);
    }

    public function test_handle_throws_an_exception_if_login_fails(): void
    {
        $this->rateLimiter->method('tooManyAttempts')->willReturn(false);
        $this->authService->method('attemptLogin')->willReturn(false);
        $this->expectException(LoginAttemptFailedException::class);
        $this->subject->handle($this->command);

    }

    public function test_handler_throws_an_exception_if_email_is_not_verified(): void
    {
        $this->rateLimiter->method('tooManyAttempts')->willReturn(false);
        $this->authService->method('attemptLogin')->willReturn(true);
        $this->authService->method('isEmailVerified')->willReturn(false);
        $this->expectException(EmailNotVerifiedException::class);
        $this->subject->handle($this->command);
    }
}
