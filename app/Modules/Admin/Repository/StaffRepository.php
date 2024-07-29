<?php
declare(strict_types=1);

namespace App\Modules\Admin\Repository;

use App\Modules\Admin\Entity\Admin;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;

class StaffRepository
{
    public function getIndex(Request $request): Arrayable
    {
        $size = $request->input('size', 20);
        return Admin::orderBy('name')
            ->paginate($size)->withQueryString()
            ->through(fn(Admin $staff) => [
                'id' => $staff->id,
                'name' => $staff->name,
                'phone' => $staff->phone,
                'fullname' => $staff->fullname->getFullName(),
                'shortname' => $staff->fullname->getShortname(),
                'post'=> $staff->post,
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
}
