<?php

declare(strict_types=1);

namespace App\Modules\Auth\UseCase\LoginUser\Command;

use App\Modules\Auth\Service\AuthServiceInterface;
use App\Modules\Auth\UseCase\LoginUser\Exception\RateLimitExceededException;
use App\Modules\Auth\UseCase\LoginUser\Exception\EmailNotVerifiedException;
use App\Modules\Auth\UseCase\LoginUser\Exception\LoginAttemptFailedException;
use App\Modules\Auth\Models\User;
use App\Modules\Auth\Service\RateLimiterInterface;
use App\Shared\CommandHandler\CommandHandlerInterface;
use App\Shared\CommandHandler\CommandInterface;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Session\Session;

/**
 * @implements CommandHandlerInterface<LoginUserCommand>
 */
final readonly class LoginUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private RateLimiterInterface $limiter,
        private AuthServiceInterface $auth,
        private Session $session,
    ) {
    }

    /**
     * @param LoginUserCommand $command
     */
    public function handle(CommandInterface $command): null
    {
        if ($this->limiter->tooManyAttempts()) {
            throw RateLimitExceededException::create($this->limiter->availableInSeconds());
        }

        if (!$this->auth->attemptLogin($command->email, $command->password)) {
            $this->limiter->increment();

            throw LoginAttemptFailedException::create();
        }

        $this->session->regenerate();
        $this->limiter->clear();

        // TODO cypress or integration for redirect to intended after email verification
        if (!$this->auth->isEmailVerified()) {
            throw EmailNotVerifiedException::create();
        }

        return null;
    }
}
