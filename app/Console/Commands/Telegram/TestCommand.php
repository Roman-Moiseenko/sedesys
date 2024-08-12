<?php
declare(strict_types=1);

namespace App\Console\Commands\Telegram;

use App\Modules\Admin\Entity\Admin;
use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Message\StaffMessage;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'telegram:test';
    protected $description = 'Отправить тестовое сообщение в чат';
    public function handle()
    {
        $admins = Admin::where('telegram_user_id', '>', 0)->get();
        foreach ($admins as $admin) {
            $admin->notify(new StaffMessage(
                NotificationHelper::EVENT_TEST,
                'Тестовое сообщение',
            ));
        }
        return true;
    }
}
