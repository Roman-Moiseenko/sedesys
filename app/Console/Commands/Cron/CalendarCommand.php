<?php
declare(strict_types=1);

namespace App\Console\Commands\Cron;

use Illuminate\Console\Command;

class CalendarCommand extends Command
{
    protected $signature = 'calendar:auto';
    protected $description = 'Проверка записей, предупреждение о записи, отключение неиспользованных';
    public function handle()
    {
        //TODO Спроектировать
        // 1. За 1 день предупредить клиента
        // 2. Сменить статус записи, если время вышло
    }
}
