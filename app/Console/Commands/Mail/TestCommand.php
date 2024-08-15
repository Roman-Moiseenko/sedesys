<?php
declare(strict_types=1);

namespace App\Console\Commands\Mail;


use App\Modules\Mail\Job\SendSystemMail;
use App\Modules\Mail\Mailable\TestMail;
use App\Modules\User\Entity\User;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'mail:test';
    protected $description = 'Отправить тестовое письмо SystemMail';
    public function handle()
    {
        try {
            $mail = new TestMail();
            dd($mail->attachments());
            $user = User::where('email', 'saint_johnny@mail.ru')->first();
            SendSystemMail::dispatch($user, $mail);
        } catch (\Throwable $e) {
            $this->error($e->getMessage() . ' ' . $e->getLine() . ' ' .$e->getFile());
        }

        return true;
    }
}
