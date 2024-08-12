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
            ->line($this->message);

        if (!is_null($this->params))
            $message->buttonWithCallback($this->params->caption, $this->params->toTelegram());

        if (!empty($this->url)) $message = $message->button('Перейти', $this->url);

        return $message;
    }
}
