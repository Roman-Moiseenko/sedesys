<?php
declare(strict_types=1);

namespace App\Console\Commands\Cron;

use Illuminate\Console\Command;

class PromotionCommand extends Command
{
    protected $signature = 'promotion:auto';
    protected $description = 'Автозапуск и остановка акций по времени, уведомление User/Admin';
    public function handle()
    {
        //TODO Автозапуск и остановка акций по времени, уведомление User/Admin

    }

}
