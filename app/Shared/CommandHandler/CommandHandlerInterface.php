<?php

declare(strict_types=1);

namespace App\Shared\CommandHandler;

/**
 * @template T of CommandInterface
 * @template V of CommandResponseInterface
 */
interface CommandHandlerInterface
{
    /**
     * @param  T  $command
     * @return null|V
     */
    public function handle(CommandInterface $command): ?CommandResponseInterface;
}
