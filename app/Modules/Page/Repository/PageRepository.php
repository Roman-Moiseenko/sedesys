<?php

namespace App\Modules\Page\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Page;

class PageRepository
{
    private TemplateRepository $templateRepository;

    public function __construct(TemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
    }

    public function getIndex(Request $request): Arrayable
    {
        return Page::orderBy('name')
            ->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Page $page) => [
                'id' => $page->id,
                'name' => $page->name,
                'slug' => $page->slug,
                'active' => $page->isPublished(),
                'published' => is_null($page->published_at) ? '' : $page->published_at->translatedFormat('d F Y'),
                'template' => $page->template,
                'url' => route('admin.page.page.show', $page),
                'edit' => route('admin.page.page.edit', $page),
                'destroy' => route('admin.page.page.destroy', $page),
                'toggle' => route('admin.page.page.toggle', $page),
            ]);
    }

    public function getTemplates(): array
    {
        $list = $this->templateRepository->getDataArray('page');
        $result = [];
        foreach ($list as $item) {
            $result[] = [
                'value' => $item['template'],
                'label' => $item['name'],
            ];
        }

        return $result;// array_select(Page::PAGES_TEMPLATES);
    }

    public function getPages(int $id = null): array
    {
        $query = Page::orderBy('name');
        if (!is_null($id)) $query->where('id', '<>', $id);

        return $query
            ->get()
            ->map(fn(Page $page) => [
            'value' => $page->id,
            'label' => $page->name,])
            ->toArray();
    }
}
