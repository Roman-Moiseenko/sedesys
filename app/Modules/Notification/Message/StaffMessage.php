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
class StaffMessage extends AbstractMessage
{

    public function via(object $notifiable): array
    {
        if (app()->environment() === 'production' && $notifiable->telegram_user_id > 0) return ['telegram', 'database'];

        return ['telegram', 'database'];
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

        //TODO Продумать возврат данных, что сотрудник подтвердил уведомление/заявку
        // ->buttonWithCallback('Подтвердить', $notifiable->id);
        if (!empty($this->route)) $message = $message->button('Перейти', $this->route);
        return $message;
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event' => NotificationHelper::EVENTS[$this->event],
            'message' => $this->message,
            'url' => $this->url,
            'params' => json_encode($this->params),
        ];
    }

}
