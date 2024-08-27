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

    public function getIndex(Request $request): array
    {
        return $this->tree();
/*
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
            ]);*/
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

    public function getPages(): array
    {
        $pages = Page::defaultOrder()->withDepth()->get();
        $result = [];
        foreach ($pages as $page) {
            $label = str_repeat(' - ', $page->depth);
            $result[] = [
                'value' => $page->id,
                'label' => $label . $page->name,
            ];
        }
        return $result;
    }


    /*
        private function getCountChildren(Page $page): int
        {
            $count = 0;
            $pages = Page::where('_lft', '>', $page->_lft)->where('_rgt', '<', $page->_rgt)->get();

            foreach ($pages as $item) {
                $count += $item->services()->count();
            }
            return $count;
        }*/
    public function getParentName(Page $page): string
    {
        if (!is_null($page->parent_id)) return Page::find($page->parent_id)->name;
        return '-';
    }

    private function tree(int $parent_id = null): array
    {
        /** @var Page[] $pages */
        $result = [];
        $pages = Page::orderBy('_lft')->where('parent_id', $parent_id)->getModels();
        /** @var Page $page */
        foreach ($pages as $page) {

            if (count($page->children) > 0)
                $children = $this->tree($page->id);

            $result[] = [
                'id' => $page->id,
                'name' => $page->name,
                'slug' => $page->slug,
                'active' => $page->isActive(),
                'published' => $page->getActivatedAt(),
                'template' => $page->template,
                'url' => route('admin.page.page.show', $page),
                'edit' => route('admin.page.page.edit', $page),
                'destroy' => route('admin.page.page.destroy', $page),
                'toggle' => route('admin.page.page.toggle', $page),

                'children' => $children ?? null,
            ];
        }
        return $result;
    }
}
