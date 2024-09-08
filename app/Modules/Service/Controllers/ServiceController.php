<?php

namespace App\Modules\Service\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Page\Repository\TemplateRepository;
use App\Modules\Service\Entity\Review;
use App\Modules\Service\Entity\Service;
use App\Modules\Service\Repository\ClassificationRepository;
use App\Modules\Service\Repository\ExampleRepository;
use App\Modules\Service\Requests\ServiceRequest;
use App\Modules\Service\Repository\ServiceRepository;
use App\Modules\Service\Service\ServiceService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{

    private ServiceService $service;
    private ServiceRepository $repository;
    private ClassificationRepository $classifications;
    private string $tiny_api;
    private ExampleRepository $exampleRepository;
    private TemplateRepository $templates;

    public function __construct(
        ServiceService           $service,
        ServiceRepository        $repository,
        ClassificationRepository $classifications,
        ExampleRepository        $exampleRepository,
        TemplateRepository       $templates,
    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->classifications = $classifications;
        $this->tiny_api = config('sedesys.tinymce');
        $this->exampleRepository = $exampleRepository;
        $this->templates = $templates;
    }


    public function index(Request $request)
    {
        $services = $this->repository->getIndex($request, $filters);
        $templates = $this->templates->getTemplates('service');
        $classifications = $this->classifications->getClassifications();

        return Inertia::render('Service/Service/Index', [
                'services' => $services,
                'filters' => $filters,
                'templates' => $templates,
                'classifications' => $classifications,
            ]
        );
    }

    public function create(Request $request)
    {
        $classifications = $this->classifications->getClassifications();
        $templates = $this->templates->getTemplates('service');

        return Inertia::render('Service/Service/Create', [
            'route' => route('admin.service.service.store'),
            'classifications' => $classifications,
            'templates' => $templates,
            'tiny_api' => $this->tiny_api,
        ]);
    }

    public function store(ServiceRequest $request)
    {
        $request->validated();
        $service = $this->service->create($request);
        return redirect()
            ->route('admin.service.service.show', $service)
            ->with('success', 'Новый service добавлен');
    }

    public function show(Service $service)
    {
        $service = $this->repository->getShow($service->id);
        $out_employees = $this->repository->outEmployees($service);
        $reviews = $this->repository->getReviews($service);
        $extras = $this->repository->getExtras($service);

        return Inertia::render('Service/Service/Show', [
                'service' => $service,
                'edit' => route('admin.service.service.edit', $service),
                'toggle' => route('admin.service.service.toggle', $service),
                'image' => $service->getImage(),
                'icon' => $service->getIcon(),


                'gallery_data' => [
                    'add' => route('admin.service.service.add', $service),
                    'del' => route('admin.service.service.del', $service),
                    'set' => route('admin.service.service.set', $service),
                    'gallery' => $this->repository->getGallery($service),
                ],
                'employee_data' => [
                    'attach' => route('admin.service.service.attach', $service),
                    'detach' => route('admin.service.service.detach', $service),
                    'out_employees' => $out_employees,
                ],
                'example_data' => [
                    'new_example' => route('admin.service.example.create', ['service_id' => $service->id]),
                    'examples' => $this->exampleRepository->getShowByService($service),

                ],
                'reviews' => $reviews,
                'extra_data' => [
                    'add' => route('admin.service.extra.store'),
                    'extras' => $extras,
                ]
            ]
        );
    }

    public function edit(Service $service)
    {
        $classifications = $this->classifications->getClassifications();
        $templates = $this->templates->getTemplates('service');

        return Inertia::render('Service/Service/Edit', [
            'service' => $service,
            'route' => route('admin.service.service.update', $service),
            'classifications' => $classifications,
            'templates' => $templates,
            'tiny_api' => $this->tiny_api,
            'image' => $service->getImage(),
            'icon' => $service->getIcon(),
        ]);
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $request->validated();
        $this->service->update($service, $request);
        if ($request->boolean('close')) {

            return redirect()
                ->route('admin.service.service.show', $service)
                ->with('success', 'Сохранение прошло успешно');
        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
    }

    public function destroy(Service $service)
    {
        $this->service->destroy($service);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function toggle(Service $service)
    {
        if ($service->isActive()) {
            $service->draft();
            $success = 'Услуга отправлена в черновик';
        } else {
            $service->activated();
            $success = 'Услуга доступна на сайте';
        }
        return redirect()->back()->with('success', $success);
    }

    public function add(Request $request, Service $service)
    {
        $this->service->addPhoto($service, $request);
        return redirect()->back()->with('success', 'Сохранено');
    }

    public function del(Request $request, Service $service)
    {
        $this->service->delPhoto($service, $request);
        return redirect()->back()->with('success', 'Сохранено');
    }

    public function set(Request $request, Service $service)
    {
        $this->service->setAlt($service, $request);
        return redirect()->back()->with('success', 'Сохранено');
    }

    public function attach(Request $request, Service $service)
    {
        $employee = $this->service->attach_employee($service, $request);
        return redirect()->back()->with('success', $employee->fullname->getShortName() . ' добавлен к оказанию услуги.');
    }

    public function detach(Request $request, Service $service)
    {
        $employee = $this->service->detach_employee($service, $request);
        return redirect()->back()->with('success', $employee->fullname->getShortName() . ' больше не оказывает услугу!');
    }
}
