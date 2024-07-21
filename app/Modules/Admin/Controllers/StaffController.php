<?php
declare(strict_types=1);

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Entity\Admin;
use App\Modules\Admin\Repository\StaffRepository;
use App\Modules\Admin\Request\StaffRequest;
use App\Modules\Admin\Service\StaffService;
use Inertia\Inertia;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    private StaffService $service;
    private StaffRepository $repository;

    public function __construct(StaffService $service, StaffRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $staffs = $this->repository->getIndex($request);

        return Inertia::render('Admin/Staff/Index', [
            'staffs' => $staffs,

        ]);
    }
    public function create()
    {
        return Inertia::render('Admin/Staff/Create', [
            'roles' => $this->repository->roles(),
            'route' => route('admin.staff.store'),
            ]);
    }

    public function store(StaffRequest $request)
    {
        $request->validated([]);

        $staff = $this->service->create($request);
        return redirect()->route('admin.staff.show', $staff)->with('success', 'Новый сотрудник добавлен');
    }

    public function show(Admin $staff)
    {
        return Inertia::render('Admin/Staff/Show', [
            'staff' => $staff,
        ]);
    }

    public function edit(Admin $staff)
    {
        return Inertia::render('Admin/Staff/Edit', [
            'roles' => $this->repository->roles(),
            'staff' => $staff,
            'photo' => !empty($staff->photo) ? $staff->photo->getUploadUrl() : null,
            'route' => route('admin.staff.update', $staff),
        ]);
    }

    public function update(Admin $staff, StaffRequest $request)
    {
        $request->validated();

        $this->service->update($staff, $request);
        return redirect()->route('admin.staff.show', $staff)->with('success', 'Сохранение прошло успешно');
    }

    public function destroy(Admin $staff)
    {
        $this->service->destroy($staff);
        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }
}
