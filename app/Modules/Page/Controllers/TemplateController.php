<?php

namespace App\Modules\Page\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Page\Entity\Template;
use App\Modules\Page\Requests\TemplateRequest;
use App\Modules\Page\Repository\TemplateRepository;
use App\Modules\Page\Service\TemplateService;
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
        return Inertia::render('Page/Template/Index', [
                'templates' => $templates,
                'store' => route('admin.page.template.store'),
                'types' => array_select(Template::TEMPLATES()), //Template::TEMPLATES
                'filters' => $filters,
            ]
        );
    }

    public function store(TemplateRequest $request)
    {
        $request->validated();
        $params = $this->service->create($request);
        return redirect()
            ->route('admin.page.template.show', $params)
            ->with('success', 'Новый Шаблон создан');
    }

    public function update(Request $request)
    {
        $this->service->update($request);

        if ($request->boolean('close')) {
            return redirect()->route('admin.page.template.index')->with('success', 'Шаблон сохранен!');
        } else {
            return redirect()->back()->with('success', 'Сохранено!');
        }
    }

    public function show($type, $template)
    {
        $file = Template::File($type, $template);

        return Inertia::render('Page/Template/Show', [
                'content' => file_get_contents($file),
                'title' => 'Шаблон ' . Template::TEMPLATES()[$type] . ' / ' . $template,
                'type' => $type,
                'template' => $template,
            ]
        );
    }

    public function destroy($type, $template)
    {
        $this->service->destroy($type, $template);
        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }
}
