<?php
declare(strict_types=1);

namespace App\Modules\Admin\Repository;

use App\Modules\Admin\Entity\Admin;
use Illuminate\Http\Request;

class StaffRepository
{
    public function getIndex(Request $request): \Illuminate\Contracts\Support\Arrayable
    {
        return Admin::orderBy('name')
            ->paginate(10)->withQueryString()
            ->through(fn(Admin $staff) => [
                'id' => $staff->id,
                'name' => $staff->name,
                'phone' => $staff->phone,
                'fullname' => $staff->fullname->getFullName(),
                'shortname' => $staff->fullname->getShortname(),
                'post'=> $staff->post,
                'role' => $staff->role,
                'active' => $staff->active,
                'url' => route('admin.staff.show', $staff),
                'edit' => route('admin.staff.edit', $staff),
                'destroy' => route('admin.staff.destroy', $staff),

            ]);
    }
}
