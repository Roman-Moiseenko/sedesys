<?php
declare(strict_types=1);

namespace App\Modules\User\Service;

use App\Modules\User\Entity\OAuth;
use App\Modules\User\Entity\User;
use App\Modules\User\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialUser;

class OAuthService
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findOrCreate(SocialUser $socialUser, string $network): User
    {
        $email = $socialUser->getEmail();
        $user = $this->repository->getByEmail($email);
        if (is_null($user)) {

            $user = User::register();

            $user->email = $email;
            $user->status = User::STATUS_ACTIVE;

            if ($network == OAuth::YANDEX) $this->YandexData($user, $socialUser);
            if ($network == OAuth::TELEGRAM) $this->TelegramData($user, $socialUser);
            if ($network == OAuth::GOOGLE) $this->GoogleData($user, $socialUser);
            if ($network == OAuth::VK) $this->VKData($user, $socialUser);



            $user->oauths()->save(OAuth::new($network, $socialUser->getId()));

        } else {
            if (!$user->isOauth($network, $socialUser->getId())) {
                $user->oauths()->save(OAuth::new($network, $socialUser->getId()));
            } else {
                //Обновить токен
            }
        }
        return $user;
    }

    private function YandexData(User $user, SocialUser $yandexUser)
    {
        $user->setNameField(surname: $yandexUser->user->last_name, firstname: $yandexUser->user->first_name);
        $user->phone = $yandexUser->user->default_phone->number;
        $user->save();
    }

    private function TelegramData(User $user, SocialUser $socialUser)
    {
        $user->setNameField(surname: 'Telegram OAuth', firstname: $socialUser->getName());

        $user->save();
    }

    private function VKData(User $user, SocialUser $socialUser)
    {
        $user->setNameField(surname: 'VK OAuth', firstname: $socialUser->getName());

        $user->save();
    }

    private function GoogleData(User $user, SocialUser $socialUser)
    {
        $user->setNameField(surname: 'Google OAuth', firstname: $socialUser->getName());

        $user->save();
    }
}
