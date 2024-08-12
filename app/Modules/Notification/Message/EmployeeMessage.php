<?php
declare(strict_types=1);

namespace App\Modules\Notification\Message;

use App\Modules\Notification\Helpers\NotificationHelper;
use NotificationChannels\Telegram\TelegramMessage;

/**
 * @property int $event
 * @property string $message
 * @property string $url
 * @property array $params
 */
class EmployeeMessage extends AbstractMessage
{
    public function via(object $notifiable): array
    {
        if (app()->environment() === 'production' && $notifiable->telegram_user_id > 0) return ['telegram'];
        return ['telegram'];
    }

    /**
     * @throws \JsonException
     */
    public function toTelegram(object $notifiable)
    {
        $message = TelegramMessage::create()
            ->content(NotificationHelper::EVENTS[$this->event])
            ->line($this->message)
            ->buttonWithCallback('Подтвердить', (string)$notifiable->id);

        return $message;
    }
}
