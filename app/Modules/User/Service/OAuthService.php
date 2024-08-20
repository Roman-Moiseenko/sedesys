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
        if (is_null($email)) {
            // Ищем user по identity в OAuth
            /** @var OAuth $oauth */
            $oauth = OAuth::where('network', $network)->where('identity', $socialUser->getId())->first();
            $user = is_null($oauth) ? null : $oauth->user;
        } else {
            //Ищем user по email
            $user = $this->repository->getByEmail($email);
        }

        if (is_null($user)) {
            $user = User::register();
            $user->email = $email;
            $user->status = User::STATUS_ACTIVE;
            $user->avatar = $socialUser->getAvatar();

            $this->$network($user, $socialUser);

            $user->oauths()->save(OAuth::new($network, $socialUser->getId()));

        } else { //Если user зарегистрирован (стандартно), но OAuth еще нет
            if (!$user->isOauth($network, $socialUser->getId())) {
                $user->oauths()->save(OAuth::new($network, $socialUser->getId()));
            }
        }
        return $user;
    }

    /**  Функции обработки данных (ФИО, Телефон), в зависимости от соц.сети $this->$network($user, $socialUser)    */


    private function yandex(User $user, SocialUser $socialUser)
    {
        $phone = $socialUser->user['default_phone']['number'];
        $user->setNameField(surname: $socialUser->user['last_name'], firstname: $socialUser->user['first_name']);
        if (!empty($phone)) {
            $user->phone = str_replace('+7', '8', $phone);
        }
        $user->save();
    }

    private function telegram(User $user, SocialUser $socialUser)
    {
        $user->setNameField(
            surname: $socialUser->user['last_name'] ?? 'Telegram OAuth',
            firstname: $socialUser->user['first_name']);

        $user->save();
    }

    private function vkontakte(User $user, SocialUser $socialUser)
    {
        $user->setNameField(surname: 'VK OAuth', firstname: $socialUser->getName());

        $user->save();
    }

    private function google(User $user, SocialUser $socialUser)
    {
        $user->setNameField(surname: 'Google OAuth', firstname: $socialUser->getName());

        $user->save();
    }
}
