<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();3
        //Получение почты
        $schedule->command('inbox:load')->hourly();
        //Запуск и остановка акций
        $schedule->command('promotion:auto')->daily();
        //Блокирование не использованных купонов
        $schedule->command('coupon:expired')->daily();

        //Верификация клиентов, удаление токена??
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
