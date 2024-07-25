<?php

namespace App\Modules\Page\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Page\Entity\Widget;
use App\Modules\Page\Requests\WidgetRequest;
use App\Modules\Page\Repository\WidgetRepository;
use App\Modules\Page\Service\WidgetService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WidgetController extends Controller
{

    private WidgetService $service;
    private WidgetRepository $repository;

    public function __construct(WidgetService $service, WidgetRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }


    public function index(Request $request)
    {
        $widgets = $this->repository->getIndex($request);

        return Inertia::render('Page/Widget/Index', [
                'widgets' => $widgets,
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('Page/Widget/Create', [
            'route' => route('admin.page.widget.store'),
        ]);
    }

    public function store(WidgetRequest $request)
    {
        $request->validated();
        $widget = $this->service->create($request);
        return redirect()
            ->route('admin.page.widget.show', $widget)
            ->with('success', 'Новый widget добавлен');
    }

    public function show(Widget $widget)
    {
        return Inertia::render('Page/Widget/Show', [
                'widget' => $widget,
                'edit' => route('admin.page.widget.edit', $widget),
            ]
        );
    }

    public function edit(Widget $widget)
    {
        return Inertia::render('Page/Widget/Edit', [
            'widget' => $widget,
            'route' => route('admin.page.widget.update', $widget),
        ]);
    }

    public function update(WidgetRequest $request, Widget $widget)
    {
        $data = $request->validated();
        $widget = $this->service->update($widget, $request);
        return redirect()
            ->route('admin.page.widget.show', $widget)
            ->with('success', 'Сохранение прошло успешно');
    }

    public function destroy(Widget $widget)
    {
        $this->service->destroy($widget);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }
}