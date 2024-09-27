<?php

namespace App\Modules\Employee\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Employee\Repository\SpecializationRepository;
use App\Modules\Employee\Requests\EmployeeRequest;
use App\Modules\Employee\Repository\EmployeeRepository;
use App\Modules\Employee\Service\EmployeeService;
use App\Modules\Page\Repository\TemplateRepository;
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
    private TemplateRepository $templates;
    private string $tiny_api;


    public function __construct(
        EmployeeService          $service,
        EmployeeRepository       $repository,
        SpecializationRepository $specializations,
        ExampleRepository        $examples,
        ServiceRepository        $services,
        TemplateRepository       $templates,
    )
    {
        $this->service = $service;
        $this->repository = $repository;

        $this->specializations = $specializations;
        $this->examples = $examples;
        $this->services = $services;
        $this->templates = $templates;
        $this->tiny_api = config('sedesys.tinymce');
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
        $templates = $this->templates->getTemplates('employee');

        return Inertia::render('Employee/Employee/Create', [
            'specializations' => $specializations,
            'templates' => $templates,
            'tiny_api' => $this->tiny_api,
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
                'services_data' => [
                    'services' => $services,
                    'out_services' => $out_services,
                ],
                'examples' => $examples,
                'image' => $employee->getImage(),
                'icon' => $employee->getIcon(),
                'specializations' => $specializations,
                'reviews' => $reviews,
            ]
        );
    }

    public function edit(Employee $employee)
    {
        $specializations = $this->repository->getSpecializations($employee);
        $templates = $this->templates->getTemplates('employee');

        $employee = Employee::where('id', $employee->id)->with('specializations:id')->first();
        return Inertia::render('Employee/Employee/Edit', [
            'employee' => $employee,
            'image' => $employee->getImage(),
            'icon' => $employee->getIcon(),
            'specializations' => $specializations,
            'templates' => $templates,
            'tiny_api' => $this->tiny_api,
        ]);
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $request->validated();
        $this->service->update($employee, $request);
        if ($request->boolean('close')) {
            return redirect()
                ->route('admin.employee.employee.show', $employee)
                ->with('success', 'Сохранение прошло успешно');
        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
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
