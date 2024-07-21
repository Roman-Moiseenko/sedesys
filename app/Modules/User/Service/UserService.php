<?php

namespace App\Modules\User\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\User\Entity\User;

class UserService
{

    public function create(Request $request): User
    {
        /**
         * Создаем объект с базовыми данными
         */
        $user = User::register(
            (string)$request->string('name')
        );

        $this->save_fields($user, $request);

        return  $user;
    }

    public function update(User $user, Request $request)
    {
        /**
         * Сохраняем базовые поля
         */
        $user->name = (string)$request->string('name');
        $user->save();

        $this->save_fields($user, $request);
    }

    private function save_fields(User $user, Request $request)
    {
        /**
         * Сохраняем оставшиеся поля
         */

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
