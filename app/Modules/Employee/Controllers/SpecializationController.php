<?php

namespace App\Modules\Employee\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Employee\Requests\SpecializationRequest;
use App\Modules\Employee\Repository\SpecializationRepository;
use App\Modules\Employee\Service\SpecializationService;
use App\Modules\Page\Repository\TemplateRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SpecializationController extends Controller
{
    private SpecializationService $service;
    private SpecializationRepository $repository;
    private TemplateRepository $templates;
    private string $tiny_api;

    public function __construct(
        SpecializationService $service,
        SpecializationRepository $repository,
        TemplateRepository       $templates,
    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->templates = $templates;
        $this->tiny_api = config('sedesys.tinymce');
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
        $employees = $this->repository->getEmployees();
        $templates = $this->templates->getTemplates('specialization');

        return Inertia::render('Employee/Specialization/Create', [
            'employees' => $employees,
            'templates' => $templates,
            'tiny_api' => $this->tiny_api,
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
        $specialization = $this->repository->getShow($specialization->id);
        $out_employees = $this->repository->outEmployees($specialization);

        return Inertia::render('Employee/Specialization/Show', [
                'specialization' => $specialization,
                'image' => $specialization->getImage(),
                'icon' => $specialization->getIcon(),
                'out_employees' => $out_employees,
            ]
        );
    }

    public function edit(Specialization $specialization)
    {
        $employees = $this->repository->getEmployees($specialization);
        $specialization = Specialization::where('id', $specialization->id)->with('employees')->first();
        $templates = $this->templates->getTemplates('specialization');

        return Inertia::render('Employee/Specialization/Edit', [
            'specialization' => $specialization,
            'image' => $specialization->getImage(),
            'icon' => $specialization->getIcon(),
            'employees' => $employees,
            'templates' => $templates,
            'tiny_api' => $this->tiny_api,
        ]);
    }

    public function update(SpecializationRequest $request, Specialization $specialization)
    {
        $request->validated();

        $this->service->update($specialization, $request);
        if ($request->boolean('close')) {
            return redirect()
                ->route('admin.employee.specialization.show', $specialization)
                ->with('success', 'Сохранение прошло успешно');
        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
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
            $success = 'Специализация убрана из показа';
        } else {
            $specialization->activated();
            $success = 'Специализация добавлена для показа';
        }
        return redirect()->back()->with('success', $success);
    }

    public function up(Specialization $specialization)
    {
        $this->service->up($specialization);
        return redirect()->back()->with('success', 'Сохранено');
    }

    public function down(Specialization $specialization)
    {
        $this->service->down($specialization);
        return redirect()->back()->with('success', 'Сохранено');
    }

    public function attach(Request $request, Specialization $specialization)
    {
        $this->service->attach($specialization, $request);
        return redirect()->back()->with('success', 'Персоналу установлена специализация');
    }

    public function detach(Request $request, Specialization $specialization)
    {
        $this->service->detach($specialization, $request);
        return redirect()->back()->with('success', 'Персонал убран из специализации');
    }
}
