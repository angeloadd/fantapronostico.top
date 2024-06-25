<?php

namespace App\Modules\League\Service\Telegram;

use App\Modules\League\Dto\TelegramReminderViewDto;
use Telegram\Bot\Exceptions\TelegramSDKException;

interface TelegramServiceInterface
{
    /**
     * @param TelegramReminderViewDto[] $dtos
     *
     * @throws TelegramSDKException
     */
    public function sendReminder(int $chatId, array $dtos): void;
}