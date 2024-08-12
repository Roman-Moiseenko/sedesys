<?php
declare(strict_types=1);

namespace App\Modules\Notification\Message;

use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Helpers\TelegramParams;
use NotificationChannels\Telegram\TelegramMessage;

/**
 * @property int $event
 * @property string $message
 * @property string $url
 * @property TelegramParams $params
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
            ->line($this->message);

        if (!is_null($this->params))
            $message->buttonWithCallback($this->params->caption, $this->params->toTelegram());

        if (!empty($this->url)) $message = $message->button('Перейти', $this->url);

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
