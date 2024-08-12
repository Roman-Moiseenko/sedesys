<?php
declare(strict_types=1);

namespace App\Modules\Notification\Message;

use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Helpers\TelegramParams;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use JetBrains\PhpStorm\ExpectedValues;

abstract class AbstractMessage extends Notification implements ShouldQueue
{
    use Queueable;

    protected int $event;
    protected string $message;
    protected string $url;
    protected TelegramParams $params;

    public function __construct(#[ExpectedValues(valuesFromClass: NotificationHelper::class)] int $event,
                                string $message,
                                string $url = '', TelegramParams $params = null)
    {
        $this->event = $event;
        $this->message = $message;
        $this->url = $url;
        $this->params = $params;
    }
}
