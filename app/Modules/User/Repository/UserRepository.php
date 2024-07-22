<?php

namespace App\Modules\User\Repository;

use App\Modules\User\Entity\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRepository
{

    public function getIndex(Request $request): Arrayable
    {
        $users = User::orderByDesc('created_at')
            ->paginate(20)->withQueryString()
            ->through(fn(User $user) => [
                'id' => $user->id,
                'phone' => phone($user->phone),
                'email' => $user->email,
                'fullname' => $user->fullname->getFullName(),
                'shortname' => $user->fullname->getShortname(),
                'address' => $user->address->address,
                'active' => $user->isActive(),
                'verify' => ($user->isWait()) ? route('admin.user.user.verify', $user) : '',
                'url' => route('admin.user.user.show', $user),
                'edit' => route('admin.user.user.edit', $user),
                'destroy' => route('admin.user.user.destroy', $user),
            ]);

        return $users;
    }
}
