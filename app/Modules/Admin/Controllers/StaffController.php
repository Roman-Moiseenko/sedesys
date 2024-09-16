<?php
declare(strict_types=1);

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Entity\Admin;
use App\Modules\Admin\Entity\Responsibility;
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
        $staffs = $this->repository->getIndex($request, $filters);

        return Inertia::render('Admin/Staff/Index', [
            'staffs' => $staffs,
            'filters' => $filters,
            'roles' => $this->repository->roles(),
        ]);
    }
    public function create()
    {
        return Inertia::render('Admin/Staff/Create', [
            'roles' => $this->repository->roles(),
            'route' => route('admin.staff.store'),
            'chat_id' => route('admin.notification.telegram.chat-id'),
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
            'staff' => $this->repository->StaffToArray($staff),
            'photo' => $staff->getImage(),
            'edit' => route('admin.staff.edit', $staff),
            'password' => route('admin.staff.password', $staff),
            'responsibilities' => array_select(Responsibility::RESPONSE),
            'set_resp' => route('admin.staff.responsibility', $staff)
        ]);
    }

    public function edit(Admin $staff)
    {
        return Inertia::render('Admin/Staff/Edit', [
            'roles' => $this->repository->roles(),
            'staff' => $staff,
            'photo' => $staff->getImage(),
            'route' => route('admin.staff.update', $staff),
            'chat_id' => route('admin.notification.telegram.chat-id'),
        ]);
    }

    public function update(Admin $staff, StaffRequest $request)
    {
        $request->validated();

        $this->service->update($staff, $request);
        if ($request->boolean('close')) {
            return redirect()->route('admin.staff.show', $staff)->with('success', 'Сохранение прошло успешно');
        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
    }

    public function destroy(Admin $staff)
    {
        $this->service->destroy($staff);
        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function password(Admin $staff, Request $request)
    {
        $request->validate([
            'password' => ['required', 'min:6'],
        ]);
        $this->service->password($staff, $request);
        return redirect()->back()->with('success', 'Пароль изменен');
    }

    public function toggle(Admin $staff)
    {
        if ($staff->isBlocked()) {
            $staff->activated();
            $success = 'Сотруднику предоставлен доступ';
        } else {
            $staff->blocked();
            $success = 'Сотрудник заблокирован';
        }
        return redirect()->back()->with('success', $success);
    }

    public function responsibility(Admin $staff, Request $request)
    {
        $this->service->responsibility($staff, $request);
        return redirect()->back()->with('success', 'Сохранено');
    }
}
