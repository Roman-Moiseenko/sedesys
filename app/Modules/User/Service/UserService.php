<?php

namespace App\Modules\User\Service;

use App\Modules\Base\Entity\FullName;
use Illuminate\Http\Request;
use App\Modules\User\Entity\User;

class UserService
{

    public function create(Request $request): User
    {
        $user = User::register($request->string('phone'), $request->string('password'));

        $this->save_fields($user, $request);
        $user->verify();
        return  $user;
    }

    public function update(User $user, Request $request)
    {
        /**
         * Сохраняем базовые поля
         */
        $user->phone = (string)$request->string('phone');
        $user->save();

        $this->save_fields($user, $request);
    }

    private function save_fields(User $user, Request $request)
    {
        $user->fullname = new FullName(
            (string)$request->string('surname'),
            (string)$request->string('firstname'),
            (string)$request->string('secondname')
        );
        $user->address->address = (string)$request->string('address');

        $user->save();
    }

    public function destroy(User $user)
    {
        /**
         * Проверить на возможность удаления
         */
        $user->delete();
    }

}
