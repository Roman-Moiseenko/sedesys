<?php

namespace App\Modules\Service\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Repository\EmployeeRepository;
use App\Modules\Page\Repository\GalleryRepository;
use App\Modules\Service\Entity\Example;
use App\Modules\Service\Entity\Service;
use App\Modules\Service\Repository\ServiceRepository;
use App\Modules\Service\Requests\ExampleRequest;
use App\Modules\Service\Repository\ExampleRepository;
use App\Modules\Service\Service\ExampleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ExampleController extends Controller
{

    private ExampleService $service;
    private ExampleRepository $repository;
    private ServiceRepository $serviceRepository;
    private EmployeeRepository $employeeRepository;
    private GalleryRepository $galleries;

    public function __construct(
        ExampleService     $service,
        ExampleRepository  $repository,
        ServiceRepository  $serviceRepository,
        EmployeeRepository $employeeRepository,
        GalleryRepository  $galleries
    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->serviceRepository = $serviceRepository;
        $this->employeeRepository = $employeeRepository;
        $this->galleries = $galleries;
    }

    public function index(Request $request): Response
    {
        $examples = $this->repository->getIndex($request, $filters);
        $services = $this->serviceRepository->forFilter();
        $employees = $this->employeeRepository->forFilter();

        return Inertia::render('Service/Example/Index', [
                'examples' => $examples,
                'filters' => $filters,
                'services' => $services,
                'employees' => $employees,
            ]
        );
    }

    public function create(Request $request): Response
    {
        $services = $this->serviceRepository->getActive();
        $employees = $this->employeeRepository->getActive();

        return Inertia::render('Service/Example/Create', [
            'services' => $services,
            'employees' => $employees,
            'service_id' => $request->integer('service_id', null),
            'employee_id' => $request->integer('employee_id', null),
        ]);
    }

    public function store(ExampleRequest $request): RedirectResponse
    {
        $request->validated();
        $example = $this->service->create($request);
        return redirect()
            ->route('admin.service.example.show', $example)
            ->with('success', 'Новый пример добавлен');
    }

    public function show(Example $example): Response
    {
        $example = Example::where('id', $example->id)->with('service')->with('employees')->first();

        return Inertia::render('Service/Example/Show', [
                'example' => $example,
                'gallery' => $this->repository->getGallery($example),
            ]
        );
    }

    public function edit(Example $example): Response
    {
        $services = $this->serviceRepository->getActive();
        $employees = $this->employeeRepository->getActive();

        $example = Example::where('id', $example->id)->with('employees:id')->first();

        return Inertia::render('Service/Example/Edit', [
            'example' => $example,
            'services' => $services,
            'employees' => $employees,
        ]);
    }

    public function update(ExampleRequest $request, Example $example): RedirectResponse
    {
        $request->validated();
        $this->service->update($example, $request);
        if ($request->boolean('close')) {
            return redirect()
                ->route('admin.service.example.show', $example)
                ->with('success', 'Сохранение прошло успешно');
        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
    }

    public function destroy(Example $example): RedirectResponse
    {
        $this->service->destroy($example);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function toggle(Example $example)
    {
        if ($example->isActive()) {
            $example->draft();
            $success = 'Работа убрана из показа на сайте';
        } else {
            $example->activated();
            $success = 'Работа добавлена на сайт';
        }
        return redirect()->back()->with('success', $success);
    }

    public function add(Request $request, Example $example)
    {
        $this->service->addPhoto($example, $request);
        return redirect()->back()->with('success', 'Сохранено');
    }

    public function del(Request $request, Example $example)
    {
        $this->service->delPhoto($example, $request);
        return redirect()->back()->with('success', 'Сохранено');
    }

    public function set(Request $request, Example $example)
    {
        $this->service->setAlt($example, $request);
        return redirect()->back()->with('success', 'Сохранено');
    }
}
