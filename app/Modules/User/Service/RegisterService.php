<?php
declare(strict_types=1);

namespace App\Modules\User\Service;

use App\Modules\Mail\Job\SendSystemMail;
use App\Modules\Mail\Mailable\VerifyMail;
use App\Modules\Notification\Message\UserMessage;
use App\Modules\Notification\Message\UserSMSMessage;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\User\Entity\User;
use Illuminate\Http\Request;

class RegisterService
{
    private \App\Modules\Setting\Entity\Web $web;

    public function __construct(SettingRepository $settings)
    {
        $this->web = $settings->getWeb();
    }

    public function register(Request $request): void
    {
        if (!$this->web->auth) throw new \DomainException('Регистрация недоступна');
        $user = User::register(
            email: $request['email'] ?? null,
            phone: $request['phone'] ?? null,
            password: $request['password']
        );
        if ($this->web->auth_phone) {
            //Отправка СМС
            $user->notify(new UserSMSMessage('SDS. Code: ' . $user->verify_token));
        } else {
            SendSystemMail::dispatch($user, new VerifyMail($user->verify_token));
        }
    }

    public function verify($id): void
    {
        $user = User::findOrFail($id);
        $user->verify();
        //event(new UserHasRegistered($user));
    }

}
