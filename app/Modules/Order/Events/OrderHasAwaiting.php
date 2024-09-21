<?php
declare(strict_types=1);

namespace App\Modules\Order\Events;

use App\Modules\Calendar\Entity\Calendar;
use App\Modules\Discount\Entity\Promotion;
use App\Modules\Order\Entity\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderHasAwaiting
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public Order $order;

    public function __construct(Order $order)
    {

        $this->order = $order;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
