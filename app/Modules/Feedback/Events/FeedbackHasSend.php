<?php
declare(strict_types=1);

namespace App\Modules\Feedback\Events;

use App\Modules\Calendar\Entity\Calendar;
use App\Modules\Feedback\Entity\Feedback;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FeedbackHasSend
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Feedback $feedback;

    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
