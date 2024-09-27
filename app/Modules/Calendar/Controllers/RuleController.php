<?php

namespace App\Modules\Calendar\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Calendar\Entity\Regularity;
use App\Modules\Calendar\Entity\Rule;
use App\Modules\Calendar\Requests\RuleRequest;
use App\Modules\Calendar\Repository\RuleRepository;
use App\Modules\Calendar\Service\RuleService;
use App\Modules\Employee\Repository\EmployeeRepository;
use App\Modules\Service\Repository\ServiceRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RuleController extends Controller
{

    private RuleService $service;
    private RuleRepository $repository;
    private ServiceRepository $services;
    private EmployeeRepository $employees;

    public function __construct(
        RuleService $service,
        RuleRepository $repository,
        ServiceRepository $services,
        EmployeeRepository $employees)
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->services = $services;
        $this->employees = $employees;
    }

    public function index(Request $request)
    {
        $rules = $this->repository->getIndex($request, $filters);
        $services = $this->services->getActive();
        $employees = $this->employees->getActive();
        $regularities = $this->repository->getRegularities();

        return Inertia::render('Calendar/Rule/Index', [
                'rules' => $rules,
                'filters' => $filters,
                'services' => $services,
                'employees' => $employees,
                'regularities' => $regularities,
            ]
        );
    }

    public function create(Request $request)
    {
        $services = $this->services->getActive();
        $employees = $this->employees->getActive();
        $regularities = $this->repository->getRegularities();

        return Inertia::render('Calendar/Rule/Create', [
            'services' => $services,
            'employees' => $employees,
            'regularities' => $regularities,
        ]);
    }

    public function store(RuleRequest $request)
    {
        $request->validated();
        $rule = $this->service->create($request);
        return redirect()
            ->route('admin.calendar.rule.show', $rule)
            ->with('success', 'Новый rule добавлен');
    }

    public function show(Rule $rule)
    {
        return Inertia::render('Calendar/Rule/Show', [
                'rule' => $this->repository->RuleToArray($rule),
            ]
        );
    }

    public function edit(Rule $rule)
    {
        $rule = Rule::where('id', $rule->id)->with(['services', 'employees'])->first();
        $services = $this->services->getActive();
        $employees = $this->employees->getActive();
        $regularities = $this->repository->getRegularities();

        return Inertia::render('Calendar/Rule/Edit', [
            'rule' => $rule,
            'services' => $services,
            'employees' => $employees,
            'regularities' => $regularities,
        ]);
    }

    public function update(RuleRequest $request, Rule $rule)
    {
        $request->validated();
        $this->service->update($rule, $request);

        if ($request->boolean('close')) {
            return redirect()
                ->route('admin.calendar.rule.show', $rule)
                ->with('success', 'Сохранение прошло успешно');
        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
    }

    public function destroy(Rule $rule)
    {
        $this->service->destroy($rule);
        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function toggle(Rule $rule)
    {
        if ($rule->isActive()) {
            $rule->draft();
            $success = 'Правило отправлено в черновики';
        } else {
            $rule->activated();
            $success = 'Правило учитывается при составлении календаря';
        }
        return redirect()->back()->with('success', $success);
    }
}
