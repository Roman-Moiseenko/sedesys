<?php
declare(strict_types=1);

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Entity\Admin;
use Inertia\Inertia;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {

        /** @var array $staffs */
        $staffs = Admin::orderBy('name')
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

        return Inertia::render('Admin/Staff/Index', [
            'staffs' => $staffs,
        ]);
    }

    public function show(Admin $staff)
    {
        return Inertia::render('Admin/Staff/Show', [
            'staff' => $staff,
        ]);
    }

    public function edit(Admin $staff) {

        return Inertia::render('Admin/Staff/Edit', [
            'staff' => $staff,
        ]);
    }

    public function update(Admin $staff, Request $request) {

        return redirect()->route('admin.staff.show', $staff)->with('success', 'Сохранение прошло успешно');

    }


    public function destroy(Admin $staff) {

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }
}
