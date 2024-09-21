<?php

namespace App\Modules\User\Service;

use App\Modules\Base\Entity\FullName;
use Illuminate\Http\Request;
use App\Modules\User\Entity\User;

class UserService
{

    public function create(Request $request): User
    {
        $user = User::register(
            phone: $request->string('phone'),
            password: $request->string('password')
        );

        $this->update($user, $request);
        $user->verify();
        return  $user;
    }

    public function update(User $user, Request $request)
    {
        if ($request->has('phone')) $user->phone = $request->string('phone')->trim()->value();
        if ($request->has('surname')) $user->fullname->surname = $request->string('surname')->trim()->value();
        if ($request->has('firstname')) $user->fullname->firstname = $request->string('firstname')->trim()->value();
        if ($request->has('secondname')) $user->fullname->secondname = $request->string('secondname')->trim()->value();
        if ($request->has('address')) $user->address->address = $request->string('address')->trim()->value();

        $email = $request->string('email')->trim()->value();
        if (!empty($email) && $user->email !== $email) {
            if (is_null(User::where('email', $email)->first())) {
                $user->email = $email;
            } else {
                throw new \DomainException('Пользователь с таким email уже существует');
            }
        }
        //throw new \DomainException(json_encode($request->all()));
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
