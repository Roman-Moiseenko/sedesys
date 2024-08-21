<?php

namespace App\Modules\Employee\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Employee\Requests\SpecializationRequest;
use App\Modules\Employee\Repository\SpecializationRepository;
use App\Modules\Employee\Service\SpecializationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SpecializationController extends Controller
{
    private SpecializationService $service;
    private SpecializationRepository $repository;

    public function __construct(SpecializationService $service, SpecializationRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $specializations = $this->repository->getIndex($request, $filters);

        return Inertia::render('Employee/Specialization/Index', [
                'specializations' => $specializations,
                'filters' => $filters,
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('Employee/Specialization/Create', [
            'route' => route('admin.employee.specialization.store'),

        ]);
    }

    public function store(SpecializationRequest $request)
    {
        $request->validated();
        $specialization = $this->service->create($request);
        return redirect()
            ->route('admin.employee.specialization.show', $specialization)
            ->with('success', 'Новый specialization добавлен');
    }

    public function show(Specialization $specialization)
    {
        $employees = $this->repository->getEmployees($specialization);

        return Inertia::render('Employee/Specialization/Show', [
                'specialization' => $specialization,
                'edit' => route('admin.employee.specialization.edit', $specialization),
                'image' => $specialization->getImage(),
                'icon' => $specialization->getIcon(),
                'toggle' => route('admin.employee.specialization.toggle', $specialization),
                'attach' => route('admin.employee.specialization.attach', $specialization),
                'employees' => $employees,
            ]
        );
    }

    public function edit(Specialization $specialization)
    {
        return Inertia::render('Employee/Specialization/Edit', [
            'specialization' => $specialization,
            'route' => route('admin.employee.specialization.update', $specialization),
            'image' => $specialization->getImage('thumb'),
            'icon' => $specialization->getIcon('thumb'),
        ]);
    }

    public function update(SpecializationRequest $request, Specialization $specialization)
    {
        $request->validated();
        $this->service->update($specialization, $request);
        return redirect()
            ->route('admin.employee.specialization.show', $specialization)
            ->with('success', 'Сохранение прошло успешно');
    }

    public function destroy(Specialization $specialization)
    {
        $this->service->destroy($specialization);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function toggle(Specialization $specialization)
    {
        if ($specialization->isActive()) {
            $specialization->draft();
        } else {
            $specialization->activated();
        }
        return redirect()->back();
    }

    public function up(Specialization $specialization)
    {
        $this->service->up($specialization);
        return redirect()->back();
    }
    public function down(Specialization $specialization)
    {
        $this->service->down($specialization);
        return redirect()->back();
    }
    public function attach(Request $request,Specialization $specialization)
    {
        $this->service->attach($specialization, $request);
        return redirect()->back()->with('success', 'Сохранено');
    }
}
