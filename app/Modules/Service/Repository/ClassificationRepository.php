<?php

namespace App\Modules\Service\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Service\Entity\Classification;

class ClassificationRepository
{

    public function getIndex(Request $request, &$filters)
    {
        return $this->tree();
    }

    public function getClassifications(): array
    {
        $classifications = Classification::defaultOrder()->withDepth()->get();
        $result = [];
        foreach ($classifications as $classification) {
            $label = str_repeat(' - ', $classification->depth);
            $result[] = [
                'value' => $classification->id,
                'label' => $label . $classification->name,
            ];
        }
        return $result;
    }

    private function tree(int $parent_id = null): array
    {
        /** @var Classification $classifications */
        $result = [];
        $classifications = Classification::orderBy('_lft')->where('parent_id', $parent_id)->getModels();
        /** @var Classification $classification */
        foreach ($classifications as $classification) {
            $count = '';
            if (count($classification->children) > 0) {
                $children = $this->tree($classification->id);
                $count = ' [' . $this->getCountChildren($classification) . ']';
            }
            $result[] = [
                'id' => $classification->id,
                'name' => $classification->name,
                'slug' => $classification->slug,
                'meta' => $classification->meta,
                'image' => $classification->getImage('mini'),
                'icon' => $classification->getIcon('mini'),
                'services' => $classification->services()->count() . $count,

                'url' => route('admin.service.classification.show', $classification),
                'edit' => route('admin.service.classification.edit', $classification),
                'destroy' => route('admin.service.classification.destroy', $classification),
                'up' => route('admin.service.classification.up', $classification),
                'down' => route('admin.service.classification.down', $classification),

                'children' => $children ?? null,
            ];
        }
        return $result;

    }

    private function getCountChildren(Classification $classification): int
    {
        $count = 0;
        $classifications = Classification::where('_lft', '>', $classification->_lft)->where('_rgt', '<', $classification->_rgt)->get();
        /** @var Classification $item */
        foreach ($classifications as $item) {
            $count += $item->services()->count();
        }
        return $count;
    }
}
