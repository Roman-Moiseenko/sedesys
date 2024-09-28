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
            ->through(fn(User $user) => $this->UserToArray($user));
    }



    public function getByEmail(string $email)
    {
        if (empty($email)) throw new \DomainException('При авторизации OAuth не удалось получить email');
        return User::where('email', $email)->first();
    }

    public function findEmailOrPhone($phone = null, $email = null):? User
    {
        if (is_null($phone)) {
            return User::where('email', $email)->first();
        }
        return User::where('phone', $phone)->first();
    }

    public function findOrCreate($phone = null, $email = null, $name = null): User
    {
        if (is_null($user = $this->findEmailOrPhone($phone, $email))) {
            $user = User::new($phone, $email);
            if (!is_null($name)) {
                $user->fullname->firstname = $name;
                $user->save();
            }
        }
        return $user;
    }

    public function UserToArray(User|null $user): array
    {
        return [
            'id' => $user->id,
            'phone' => $user->phone,
            'email' => $user->email,
            'fullname' => $user->fullname,
            'address' => $user->address->address,
            'avatar' => $user->avatar,
            'oauths' => array_map(function (OAuth $item) {
                return $item->network;
            }, $user->oauths()->getModels()),
            'active' => $user->isActive(),
            'verify' => ($user->isWait()) ? route('admin.user.user.verify', $user) : '',

        ];

    }
}
