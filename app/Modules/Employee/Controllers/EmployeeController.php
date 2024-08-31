<?php

namespace App\Modules\Employee\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Employee\Repository\SpecializationRepository;
use App\Modules\Employee\Requests\EmployeeRequest;
use App\Modules\Employee\Repository\EmployeeRepository;
use App\Modules\Employee\Service\EmployeeService;
use App\Modules\Service\Repository\ExampleRepository;
use App\Modules\Service\Repository\ServiceRepository;
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
    private SpecializationRepository $specializations;
    private ExampleRepository $examples;
    private ServiceRepository $services;


    public function __construct(
        EmployeeService          $service,
        EmployeeRepository       $repository,
        SpecializationRepository $specializations,
        ExampleRepository        $examples,
        ServiceRepository        $services
    )
    {
        $this->service = $service;
        $this->repository = $repository;

        $this->specializations = $specializations;
        $this->examples = $examples;
        $this->services = $services;
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
        $specializations = $this->specializations->getShowByEmployee($employee);

        $out_services = $this->repository->outServices($employee);
        $examples = $this->examples->getShowByEmployee($employee);
        $services = $this->services->getShowByEmployee($employee);
        $reviews = $this->repository->getReviews($employee);

        return Inertia::render('Employee/Employee/Show', [
                'employee' => $employee,
                'edit' => route('admin.employee.employee.edit', $employee),
                'toggle' => route('admin.employee.employee.toggle', $employee),
                'attach' => route('admin.employee.employee.attach-service', $employee),
                'detach' => route('admin.employee.employee.detach-service', $employee),
                'new_example' => route('admin.service.example.create', ['employee_id' => $employee->id]),
                'image' => $employee->getImage(),
                'icon' => $employee->getIcon(),
                'specializations' => $specializations,
                'services' => $services,
                'reviews' => $reviews,
                'out_services' => $out_services,
                'examples' => $examples,
            ]
        );
    }

    public function edit(Employee $employee)
    {
        $specializations = $this->repository->getSpecializations($employee);

        return Inertia::render('Employee/Employee/Edit', [
            'employee' => $employee,
            'route' => route('admin.employee.employee.update', $employee),
            'image' => $employee->getImage(),
            'icon' => $employee->getIcon(),
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
        if ($employee->isActive()) {
            $employee->draft();
            $success = 'Работник убран из показа';
        } else {
            $employee->activated();
            $success = 'Работник добавлен на сайт';
        }
        return redirect()->back()->with('success', $success);
    }

    public function attach(Request $request, Employee $employee)
    {
        $service = $this->service->attach_service($employee, $request);
        return redirect()->back()->with('success', 'Услуга ' . $service->name . ' добавлена.');
    }

    public function detach(Request $request, Employee $employee)
    {
        $service = $this->service->detach_service($employee, $request);
        return redirect()->back()->with('success', 'Услуга ' . $service->name . ' убрана.');
    }
}
