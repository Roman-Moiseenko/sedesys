<?php

namespace App\Modules\Page\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Page\Entity\Page;
use App\Modules\Page\Requests\PageRequest;
use App\Modules\Page\Repository\PageRepository;
use App\Modules\Page\Service\PageService;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{

    private PageService $service;
    private PageRepository $repository;
    private string $tiny_api;

    public function __construct(PageService $service, PageRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->tiny_api = config('sedesys.tinymce');
    }


    public function index(Request $request)
    {
        $pages = $this->repository->getIndex($request);

        return Inertia::render('Page/Page/Index', [
                'pages' => $pages,
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('Page/Page/Create', [
            'route' => route('admin.page.page.store'),
            'templates' => $this->repository->getTemplates(),
            'pages' => $this->repository->getPages(),
            'tiny_api' => $this->tiny_api,
        ]);
    }

    public function store(PageRequest $request)
    {
        $request->validated();
        $page = $this->service->create($request);
        return redirect()
            ->route('admin.page.page.show', $page)
            ->with('success', 'Новая страница добавлена');
    }

    public function show(Page $page)
    {
        return Inertia::render('Page/Page/Show', [
                'page' => $page,
                'parent' => is_null($page->parent_id) ? '-' : $page->parent->name,
                'edit' => route('admin.page.page.edit', $page),
                'photo' => !empty($page->photo) ? $page->photo->getUploadUrl() : null,
                'toggle' => route('admin.page.page.toggle', $page),
            ]
        );
    }

    public function edit(Page $page)
    {
        return Inertia::render('Page/Page/Edit', [
            'page' => $page,
            'route' => route('admin.page.page.update', $page),
            'templates' => $this->repository->getTemplates(),
            'pages' => $this->repository->getPages($page->id),
            'photo' => !empty($page->photo) ? $page->photo->getUploadUrl() : null,
            'tiny_api' => $this->tiny_api,
        ]);
    }

    public function update(PageRequest $request, Page $page)
    {
        $request->validated();
        $this->service->update($page, $request);
        return redirect()
            ->route('admin.page.page.show', $page)
            ->with('success', 'Сохранение прошло успешно');
    }

    public function destroy(Page $page)
    {
        $this->service->destroy($page);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function toggle(Page $page)
    {
        if ($page->isPublished()) {
            $page->draft();
        } else {
            $page->published();
        }
        return redirect()->back();
    }
}
