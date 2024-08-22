<?php

namespace App\Modules\Service\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Service\Entity\Service;
use App\Modules\Service\Repository\ClassificationRepository;
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

    public function __construct(
        ServiceService $service,
        ServiceRepository $repository,
        ClassificationRepository $classifications)
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->classifications = $classifications;
        $this->tiny_api = config('sedesys.tinymce');
    }


    public function index(Request $request)
    {
        $services = $this->repository->getIndex($request, $filters);
        $templates = $this->repository->getTemplates();
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
        $templates = $this->repository->getTemplates();

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
        $service = Service::where('id', $service->id)->with('classification')->first();

        return Inertia::render('Service/Service/Show', [
                'service' => $service,
                'edit' => route('admin.service.service.edit', $service),
                'toggle' => route('admin.service.service.toggle', $service),
                'image' => $service->getImage(),
                'icon' => $service->getIcon(),
                'add' => route('admin.service.service.add', $service),
                'del' => route('admin.service.service.del', $service),
                'set' => route('admin.service.service.set', $service),
                'gallery' => $this->repository->getGallery($service),
            ]
        );
    }

    public function edit(Service $service)
    {
        $classifications = $this->classifications->getClassifications();
        $templates = $this->repository->getTemplates();

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
        return redirect()
            ->route('admin.service.service.show', $service)
            ->with('success', 'Сохранение прошло успешно');
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
        } else {
            $service->activated();
        }
        return redirect()->back();
    }

    public function add(Request $request, Service $service)
    {
        $this->service->addPhoto($service, $request);
        return redirect()->back();
    }

    public function del(Request $request, Service $service)
    {
        $this->service->delPhoto($service, $request);
        return redirect()->back();
    }

    public function set(Request $request, Service $service)
    {
        $this->service->setAlt($service, $request);
        return redirect()->back();
    }
}
