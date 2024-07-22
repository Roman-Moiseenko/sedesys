<?php

namespace App\Modules\Employee\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Employee;
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
        $employees = $this->repository->getIndex($request);

        return Inertia::render('Employee/Employee/Index', [
                'employees' => $employees,
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('Employee/Employee/Create', [
            'route' => route('admin.employee.employee.store'),
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
            ]
        );
    }

    public function edit(Employee $employee)
    {
        return Inertia::render('Employee/Employee/Edit', [
            'employee' => $employee,
            'route' => route('admin.employee.employee.update', $employee),
        ]);
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();
        $employee = $this->service->update($employee, $request);
        return redirect()
            ->route('admin.employee.employee.show', $employee)
            ->with('success', 'Сохранение прошло успешно');
    }

    public function destroy(Employee $employee)
    {
        $this->service->destroy($employee);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }
}
