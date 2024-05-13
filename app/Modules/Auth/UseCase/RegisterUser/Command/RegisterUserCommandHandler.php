<?php

declare(strict_types=1);

namespace App\Modules\Auth\UseCase\RegisterUser\Command;

use App\Shared\CommandHandler\CommandHandlerInterface;
use App\Shared\CommandHandler\CommandInterface;
use App\Shared\CommandHandler\CommandResponseInterface;

/**
 * @implements CommandHandlerInterface<RegisterUserCommand>
 */
final class RegisterUserCommandHandler implements CommandHandlerInterface
{
    /**
     * @param RegisterUserCommand $command
     */
    public function handle(CommandInterface $command): null
    {

    }
}
