<?php
declare(strict_types=1);

namespace App\Modules\Calendar\Events;

use App\Modules\Calendar\Entity\Calendar;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecordHasChangeStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Calendar $calendar;

    public function __construct(Calendar $calendar)
    {
        $this->calendar = $calendar;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
