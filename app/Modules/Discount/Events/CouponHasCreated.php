<?php
declare(strict_types=1);

namespace App\Modules\Discount\Events;

use App\Modules\Calendar\Entity\Calendar;
use App\Modules\Discount\Entity\Coupon;
use App\Modules\Discount\Entity\Promotion;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CouponHasCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public Coupon $coupon;

    public function __construct(Coupon $coupon)
    {

        $this->coupon = $coupon;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
