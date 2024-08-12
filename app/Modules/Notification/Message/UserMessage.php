<?php
declare(strict_types=1);

namespace App\Modules\Notification\Message;

/**
 * @property int $event
 * @property string $message
 * @property string $url
 * @property array $params
 */
class UserMessage extends  AbstractMessage
{
    public function via(object $notifiable): array
    {
        //TODO Google_Calendar, VK, SMS
        return [];
    }
}
