<?php

namespace App\Modules\Service\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Page\Repository\TemplateRepository;
use App\Modules\Service\Entity\Classification;
use App\Modules\Service\Repository\ServiceRepository;
use App\Modules\Service\Requests\ClassificationRequest;
use App\Modules\Service\Repository\ClassificationRepository;
use App\Modules\Service\Service\ClassificationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClassificationController extends Controller
{

    private ClassificationService $service;
    private ClassificationRepository $repository;
    private ServiceRepository $serviceRepository;
    private TemplateRepository $templates;
    private string $tiny_api;

    public function __construct(
        ClassificationService    $service,
        ClassificationRepository $repository,
        ServiceRepository        $serviceRepository,
        TemplateRepository       $templates,
    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->serviceRepository = $serviceRepository;
        $this->templates = $templates;
        $this->tiny_api = config('sedesys.tinymce');

    }

    public function index(Request $request)
    {
        $classifications = $this->repository->getIndex($request, $filters);

        return Inertia::render('Service/Classification/Index', [
                'classifications' => $classifications,
            ]
        );

    }

    public function create(Request $request)
    {
        $classifications = $this->repository->getClassifications();
        $templates = $this->templates->getTemplates('classification');

        return Inertia::render('Service/Classification/Create', [
            'route' => route('admin.service.classification.store'),
            'classifications' => $classifications,
            'templates' => $templates,
            'tiny_api' => $this->tiny_api,
        ]);
    }

    public function store(ClassificationRequest $request)
    {
        $request->validated();
        $classification = $this->service->create($request);
        return redirect()
            ->route('admin.service.classification.show', $classification)
            ->with('success', 'Новый classification добавлен');
    }

    public function show(Classification $classification)
    {
        $services = $this->serviceRepository->getShowByClassification($classification);

        return Inertia::render('Service/Classification/Show', [
                'classification' => $classification,
                'edit' => route('admin.service.classification.edit', $classification),
                'toggle' => route('admin.service.classification.toggle', $classification),
                'image' => $classification->getImage(),
                'icon' => $classification->getIcon(),
                'services' => $services,
            ]
        );
    }

    public function edit(Classification $classification)
    {
        $classifications = $this->repository->getClassifications();
        $templates = $this->templates->getTemplates('classification');

        return Inertia::render('Service/Classification/Edit', [
            'classification' => $classification,
            'route' => route('admin.service.classification.update', $classification),
            'image' => $classification->getImage(),
            'icon' => $classification->getIcon(),
            'classifications' => $classifications,
            'templates' => $templates,
            'tiny_api' => $this->tiny_api,
        ]);
    }

    public function update(ClassificationRequest $request, Classification $classification)
    {
        $request->validated();
        $this->service->update($classification, $request);

        if ($request->boolean('close')) {
            return redirect()
                ->route('admin.service.classification.show', $classification)
                ->with('success', 'Сохранение прошло успешно');

        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
    }

    public function destroy(Classification $classification)
    {
        $this->service->destroy($classification);
        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function up(Classification $classification)
    {
        $classification->up();
        return redirect()->back()->with('success', 'Сохранено');
    }

    public function down(Classification $classification)
    {
        $classification->down();
        return redirect()->back()->with('success', 'Сохранено');
    }

    public function toggle(Classification $classification)
    {
        if ($classification->isActive()) {
            $classification->draft();
            $success = 'Классификация убрана из показа';
        } else {
            $classification->activated();
            $success = 'Классификация доступна на сайте';
        }
        return redirect()->back()->with('success', $success);
    }
}
