<?php
declare(strict_types=1);

namespace App\Console\Commands\Mail;

use App\Modules\Admin\Entity\Admin;
use App\Modules\Mail\Mailable\TestMail;
use App\Modules\Mail\Service\SystemMailService;
use App\Modules\Notification\Helpers\NotificationHelper;
use App\Modules\Notification\Helpers\TelegramParams;
use App\Modules\Notification\Message\StaffMessage;
use http\Client\Curl\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestCommand extends Command
{
    protected $signature = 'mail:test';
    protected $description = 'Отправить тестовое письмо SystemMail';
    public function handle(SystemMailService $service)
    {
        $mail = new TestMail();
        $user = User::where('email', 'saint_johnny@mail.ru')->first();
        $service->create($mail, $user->id);

        Mail::to($user->email)->queue($mail);
        return true;
    }
}
