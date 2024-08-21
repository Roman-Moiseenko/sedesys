<?php

namespace App\Modules\User\Repository;

use App\Modules\User\Entity\OAuth;
use App\Modules\User\Entity\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = User::orderByDesc('created_at');
        //TODO Фильтр Без учета регистра
        $filters = [];

        if ($request->has('user')) {
            $user = $request->string('user')->trim()->value();
            $filters['user'] = $user;
            $query->where(function ($q) use ($user) {
                $q->orWhere('fullname', 'LIKE', "%$user%")
                    ->orWhere('phone', 'LIKE', "%$user%")
                ->orWhere('email', 'LIKE', "%$user%");
            });
        }
        if ($request->has('address')) {
            $address = $request->string('address')->trim()->value();
            $filters['address'] = $address;
            $query->where('address', 'LIKE', "%$address%");
        }
        if ($request->input('draft', 'false') == 'true' ) {
            $filters['draft'] = 'true';
            $query->where('status', User::STATUS_WAIT);
        }
        //TODO Другие данные клиента
        if (count($filters) > 0) $filters['count'] = count($filters);
        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(User $user) => [
                'id' => $user->id,
                'phone' => phone($user->phone),
                'email' => $user->email,
                'fullname' => $user->fullname->getFullName(),
                'shortname' => $user->fullname->getShortname(),
                'address' => $user->address->address,
                'avatar' => $user->avatar,
                'oauths' => array_map(function (OAuth $item){
                    return $item->network;
                }, $user->oauths()->getModels()),
                'active' => $user->isActive(),
                'verify' => ($user->isWait()) ? route('admin.user.user.verify', $user) : '',
                'url' => route('admin.user.user.show', $user),
                'edit' => route('admin.user.user.edit', $user),
                'destroy' => route('admin.user.user.destroy', $user),
            ]);
    }



    public function getByEmail(string $email)
    {
        if (empty($email)) throw new \DomainException('При авторизации OAuth не удалось получить email');
        return User::where('email', $email)->first();
    }

    public function findEmailOrPhone($phone, $email):? User
    {
        if (is_null($phone)) {
            return User::where('email', $email)->first();
        }
        return User::where('phone', $email)->first();
    }
}
