<?php

namespace App\Modules\Page\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Page;

class PageRepository
{

    public function getIndex(Request $request): array
    {
        return $this->tree();
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
                'children' => $children ?? null,
            ];
        }
        return $result;
    }
}
