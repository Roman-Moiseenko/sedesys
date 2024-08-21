<?php

namespace App\Modules\Employee\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Employee\Requests\EmployeeRequest;
use App\Modules\Employee\Repository\EmployeeRepository;
use App\Modules\Employee\Service\EmployeeService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;

class EmployeeController extends Controller
{

    private EmployeeService $service;
    private EmployeeRepository $repository;

    public function __construct(EmployeeService $service, EmployeeRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $employees = $this->repository->getIndex($request, $filters);
        $specializations = $this->repository->getSpecializationForFilter();

        return Inertia::render('Employee/Employee/Index', [
                'employees' => $employees,
                'filters' => $filters,
                'specializations' => $specializations,
            ]
        );
    }

    public function create(Request $request)
    {
        $specializations = $this->repository->getSpecializations();
        return Inertia::render('Employee/Employee/Create', [
            'route' => route('admin.employee.employee.store'),
            'chat_id' => route('admin.notification.telegram.chat-id'),
            'specializations' => $specializations,
        ]);
    }

    public function store(EmployeeRequest $request)
    {
        $request->validated();
        $employee = $this->service->create($request);
        return redirect()
            ->route('admin.employee.employee.show', $employee)
            ->with('success', 'Персонал добавлен');
    }

    public function show(Employee $employee)
    {
        return Inertia::render('Employee/Employee/Show', [
                'employee' => $employee,
                'edit' => route('admin.employee.employee.edit', $employee),
                'photo' => $employee->getImage(),
                'specializations' => $employee->specializations()->get()->map(function (Specialization $specialization) {
                    return [
                        'name' => $specialization->name,
                        'icon' => $specialization->getIcon('thumb'),
                    ];
                })->toArray(),
            ]
        );
    }

    public function edit(Employee $employee)
    {
        $specializations = $this->repository->getSpecializations($employee);

        return Inertia::render('Employee/Employee/Edit', [
            'employee' => $employee,
            'route' => route('admin.employee.employee.update', $employee),
            'photo' => $employee->getImage(),
            'chat_id' => route('admin.notification.telegram.chat-id'),
            'specializations' => $specializations,
        ]);
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $request->validated();
        $this->service->update($employee, $request);
        return redirect()
            ->route('admin.employee.employee.show', $employee)
            ->with('success', 'Сохранение прошло успешно');
    }

    public function destroy(Employee $employee)
    {
        $this->service->destroy($employee);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function toggle(Employee $employee)
    {
        if ($employee->isBlocked()) {
            $employee->activated();
        } else {
            $employee->blocked();
        }
        return redirect()->back();
    }

    public function attach(Request $request,Employee $employee)
    {
        $this->service->attach($employee, $request);
        return redirect()->back()->with('success', 'Сохранено');
    }
}
