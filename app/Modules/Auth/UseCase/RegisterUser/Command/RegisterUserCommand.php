<?php

declare(strict_types=1);

namespace App\Modules\Auth\UseCase\RegisterUser\Command;

use App\Shared\CommandHandler\CommandInterface;

final readonly class RegisterUserCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $password
    ) {
    }
}
