<?php
declare(strict_types=1);

namespace App\Console\Commands\Cron;

use App\Modules\Discount\Entity\Coupon;
use Illuminate\Console\Command;

class CouponCommand extends Command
{
    protected $signature = 'coupon:expired';
    protected $description = 'Отключение неиспользованных купонов';
    public function handle()
    {
        $coupons = Coupon::where('status', Coupon::NEW)->where('finish_at','<>', null)->where('finish_at', '<=', now())->get();
        foreach ($coupons as $coupon) {
            $coupon->expired();
        }
    }

}
