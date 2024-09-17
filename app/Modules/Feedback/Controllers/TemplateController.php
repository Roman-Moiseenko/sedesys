<?php

namespace App\Modules\Feedback\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Feedback\Entity\Template;
use App\Modules\Feedback\Requests\TemplateRequest;
use App\Modules\Feedback\Repository\TemplateRepository;
use App\Modules\Feedback\Service\TemplateService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TemplateController extends Controller
{

    private TemplateService $service;
    private TemplateRepository $repository;

    public function __construct(TemplateService $service, TemplateRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }


    public function index(Request $request)
    {
        $templates = $this->repository->getIndex($request, $filters);

        return Inertia::render('Feedback/Template/Index', [
                'templates' => $templates,
                'filters' => $filters,
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('Feedback/Template/Create', [
            'route' => route('admin.feedback.template.store'),
        ]);
    }

    public function store(TemplateRequest $request)
    {
        $request->validated();
        $template = $this->service->create($request);
        return redirect()
            ->route('admin.feedback.template.show', $template)
            ->with('success', 'Новый template добавлен');
    }

    public function show(Template $template)
    {

        return Inertia::render('Feedback/Template/Show', [
                'template' => $this->repository->TemplateWithToArray($template),
                'edit' => route('admin.feedback.template.edit', $template),
            ]
        );
    }

    public function edit(Template $template)
    {

        return Inertia::render('Feedback/Template/Edit', [
            'template' => $this->repository->TemplateToArray($template),
            'route' => route('admin.feedback.template.update', $template),
        ]);
    }

    public function update(TemplateRequest $request, Template $template)
    {
        $request->validated();
        $this->service->update($template, $request);

        if ($request->boolean('close')) {
            return redirect()
                ->route('admin.feedback.template.show', $template)
                ->with('success', 'Сохранение прошло успешно');
        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
    }

    public function destroy(Template $template)
    {
        $this->service->destroy($template);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function toggle(Template $template)
    {
        if ($template->isActive()) {
            $template->draft();
            $success = 'Форма больше не принимает заявки';
        } else {
            $template->activated();
            $success = 'Форма принимает заявки';
        }
        return redirect()->back()->with('success', $success);
    }
}
