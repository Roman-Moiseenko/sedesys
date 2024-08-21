<?php
declare(strict_types=1);

namespace App\Modules\Admin\Repository;

use App\Modules\Admin\Entity\Admin;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;

class StaffRepository
{
    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Admin::orderBy('name');
        //TODO Фильтр Без учета регистра
        $filters = [];

        if ($request->has('user')) {
            $user = $request->string('user')->trim()->value();
            $filters['user'] = $user;
            $query->where(function ($q) use ($user) {
                $q->orWhere('fullname', 'LIKE', "%$user%")
                    ->orWhere('phone', 'LIKE', "%$user%");
            });
        }
        if ($request->has('role')) {
            $role = $request->string('role')->trim()->value();
            $filters['role'] = $role;
            $query->where('role', $role);
        }

        if ($request->input('draft', 'false') == 'true' ) {
            $filters['draft'] = 'true';
            $query->where('active', false);
        }
        if (count($filters) > 0) $filters['count'] = count($filters);

        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Admin $staff) => [
                'id' => $staff->id,
                'name' => $staff->name,
                'phone' => $staff->phone,
                'fullname' => $staff->fullname->getFullName(),
                'shortname' => $staff->fullname->getShortname(),
                'post' => $staff->post,
                'role' => $staff->roleHTML(),
                'active' => $staff->active,
                'url' => route('admin.staff.show', $staff),
                'edit' => route('admin.staff.edit', $staff),
                'destroy' => route('admin.staff.destroy', $staff),
                'toggle' => route('admin.staff.toggle', $staff),
            ]);
    }

    public function roles(): array
    {
        return array_select(Admin::ROLES);
    }

    public function byTelegram(int $telegram_id): ?Admin
    {
        return Admin::where('telegram_user_id', $telegram_id)->first();
    }
}

