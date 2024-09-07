<?php
declare(strict_types=1);

namespace App\Modules\Discount\Events;

use App\Modules\Calendar\Entity\Calendar;
use App\Modules\Discount\Entity\Promotion;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PromotionHasStart
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public Promotion $promotion;

    public function __construct(Promotion $promotion)
    {

        $this->promotion = $promotion;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
