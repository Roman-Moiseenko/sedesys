<?php

namespace App\Modules\Service\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Page\Repository\TemplateRepository;
use App\Modules\Service\Entity\Review;
use App\Modules\Service\Entity\Service;
use App\Modules\Service\Repository\ClassificationRepository;
use App\Modules\Service\Repository\ConsumableRepository;
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
    private ConsumableRepository $consumables;

    public function __construct(
        ServiceService           $service,
        ServiceRepository        $repository,
        ClassificationRepository $classifications,
        ExampleRepository        $exampleRepository,
        TemplateRepository       $templates,
        ConsumableRepository     $consumables,
    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->classifications = $classifications;
        $this->tiny_api = config('sedesys.tinymce');
        $this->exampleRepository = $exampleRepository;
        $this->templates = $templates;
        $this->consumables = $consumables;
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
                'image' => $service->getImage(),
                'icon' => $service->getIcon(),
                'gallery' => $this->repository->getGallery($service),
                'out_employees' => $out_employees,
                'examples' => $this->exampleRepository->getShowByService($service),
                'out_consumables' => $this->repository->outConsumables($service),
                //  'consumables' => $this->consumables->getShowByService($service),
                'reviews' => $reviews,
                'extras' => $extras,
            ]
        );
    }

    public function edit(Service $service)
    {
        $classifications = $this->classifications->getClassifications();
        $templates = $this->templates->getTemplates('service');

        return Inertia::render('Service/Service/Edit', [
            'service' => $service,
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

    public function attach_consumable(Request $request, Service $service)
    {
        $consumable = $this->service->attach_consumable($service, $request);
        return redirect()->back()->with('success', $consumable->name . ' добавлен к услуге.');
    }

    public function detach_consumable(Request $request, Service $service)
    {
        $consumable = $this->service->detach_consumable($service, $request);
        return redirect()->back()->with('success', $consumable->name . ' убран из услуги!');
    }

}
