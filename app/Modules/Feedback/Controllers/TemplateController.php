<?php

namespace App\Modules\Feedback\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Feedback\Entity\Template;
use App\Modules\Feedback\Requests\TemplateRequest;
use App\Modules\Feedback\Repository\TemplateRepository;
use App\Modules\Feedback\Service\TemplateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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

    public function show(Template $template): Response
    {

        return Inertia::render('Feedback/Template/Show', [
                'template' => $this->repository->TemplateWithToArray($template),
            ]
        );
    }

    public function edit(Template $template): Response
    {
        return Inertia::render('Feedback/Template/Edit', [
            'template' => $this->repository->TemplateToArray($template),
        ]);
    }

    public function update(TemplateRequest $request, Template $template): RedirectResponse
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

    public function destroy(Template $template): RedirectResponse
    {
        $this->service->destroy($template);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function toggle(Template $template): RedirectResponse
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
