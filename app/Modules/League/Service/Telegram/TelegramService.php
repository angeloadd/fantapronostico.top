<?php

declare(strict_types=1);

namespace App\Modules\League\Service\Telegram;

use App\Modules\League\Dto\TelegramReminderViewDto;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;

final class TelegramService implements TelegramServiceInterface
{
    /**
     * @param TelegramReminderViewDto[] $dtos
     *
     * @throws TelegramSDKException
     */
    public function sendReminder(int $chatId, array $dtos): void
    {
        $bot = Telegram::bot('fpbot');
        foreach ($dtos as $dto) {
            $bot->sendMessage([
                'chat_id' => -1001766446905,
                'text' => view('telegram.game', compact('dto'))->render(),
                'parse_mode' => 'HTML',
            ]);
        }

    }
}
