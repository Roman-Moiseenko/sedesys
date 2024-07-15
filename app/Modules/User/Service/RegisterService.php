<?php
declare(strict_types=1);

namespace App\Modules\User\Service;

use App\Modules\User\Entity\User;
use Illuminate\Http\Request;

class RegisterService
{
    public function register(Request $request): void
    {
        $user = User::register(
            $request['email'],
            // $request['phone'],
            $request['password']
        );
        //TODO События
       // event(new UserHasCreated($user));
    }

    public function verify($id): void
    {
        $user = User::findOrFail($id);
        $user->verify();
        //event(new UserHasRegistered($user));
    }

    public function newUser($email, $password)
    {
        //$user = User::where($email)->first();
        $user = User::register(
            $email,
            // $request['phone'],
            $password
        );
        return $user;
    }
}