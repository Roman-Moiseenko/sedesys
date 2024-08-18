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

    public function findOrCreate(SocialUser $yandexUser, string $network): User
    {
        $email = $yandexUser->getEmail();
        $user = $this->repository->getByEmail($email);
        if (is_null($user)) {

            $user = User::register(null, Hash::make(Str::random(24)));

            $user->email = $email;
            $user->status = User::STATUS_ACTIVE;
            $user->setNameField(surname: 'Yandex OAuth', firstname: $yandexUser->getName());
            $user->save();

            $user->oauths()->create(OAuth::register([
                'network' => $network,
                'identity' => $yandexUser->getId(),
            ]));

        } else {
            if (!$user->isOauth($network, $yandexUser->getId())) {
                $user->oauths()->create(OAuth::register([
                    'network' => 'yandex',
                    'identity' => $yandexUser->getId(),
                ]));
            } else {
                //Обновить токен
            }
        }
        return $user;
    }
}
