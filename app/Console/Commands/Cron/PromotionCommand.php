<?php
declare(strict_types=1);

namespace App\Console\Commands\Cron;

use App\Modules\Discount\Entity\Promotion;
use App\Modules\Discount\Events\PromotionHasFinish;
use App\Modules\Discount\Events\PromotionHasStart;
use Illuminate\Console\Command;

class PromotionCommand extends Command
{
    protected $signature = 'promotion:auto';
    protected $description = 'Автозапуск и остановка акций по времени, уведомление User/Admin';
    public function handle()
    {
        //Акции для запуска
        $promotions = Promotion::where('active', true)->where('current', false)->where('start_at', '<>', null)->where('start_at', '<=', now())->get();
        foreach ($promotions as $promotion) {
            $promotion->start();
            $promotion->save();
            event(new PromotionHasStart($promotion));
        }

        //Акции для остановки
        $promotions = Promotion::where('current', true)->where('finish_at', '<>', null)->where('finish_at', '<=', now())->get();
        foreach ($promotions as $promotion) {
            $promotion->finish();
            $promotion->save();
            event(new PromotionHasFinish($promotion));
        }

    }

}
