<?php

namespace App\Modules\Service\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Service\Entity\Classification;
use App\Modules\Service\Requests\ClassificationRequest;
use App\Modules\Service\Repository\ClassificationRepository;
use App\Modules\Service\Service\ClassificationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClassificationController extends Controller
{

    private ClassificationService $service;
    private ClassificationRepository $repository;

    public function __construct(ClassificationService $service, ClassificationRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
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
        return Inertia::render('Service/Classification/Create', [
            'route' => route('admin.service.classification.store'),
            'classifications' => $classifications,
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
        return Inertia::render('Service/Classification/Show', [
                'classification' => $classification,
                'edit' => route('admin.service.classification.edit', $classification),
                'image' => $classification->getImage(),
                'icon' => $classification->getIcon(),
            ]
        );
    }

    public function edit(Classification $classification)
    {
        $classifications = $this->repository->getClassifications();

        return Inertia::render('Service/Classification/Edit', [
            'classification' => $classification,
            'route' => route('admin.service.classification.update', $classification),
            'image' => $classification->getImage(),
            'icon' => $classification->getIcon(),
            'classifications' => $classifications,
        ]);
    }

    public function update(ClassificationRequest $request, Classification $classification)
    {
        $request->validated();
        $this->service->update($classification, $request);
        return redirect()
            ->route('admin.service.classification.show', $classification)
            ->with('success', 'Сохранение прошло успешно');
    }

    public function destroy(Classification $classification)
    {
        $this->service->destroy($classification);
        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function up(Classification $classification)
    {
        $classification->up();
        return redirect()->back();
    }

    public function down(Classification $classification)
    {
        $classification->down();
        return redirect()->back();
    }
}
