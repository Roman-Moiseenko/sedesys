<?php

namespace App\Modules\Page\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Widget;

class WidgetRepository
{

    public function getIndex(Request $request): Arrayable
    {
        return Widget::orderBy('name')
            ->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Widget $widget) => [
                'id' => $widget->id,
                'name' => $widget->name,
                'model' => $widget->model,
                'template' => $widget->template,
                'short' => '[widget="'. $widget->id . '"]',
                'url' => route('admin.page.widget.show', $widget),
                'edit' => route('admin.page.widget.edit', $widget),
                'destroy' => route('admin.page.widget.destroy', $widget),
            ]);
    }

    public function getModels(): array
    {
        return array_select(Widget::WIDGET_MODELS);
    }

    public function getTemplates(): array
    {
        return array_select(Widget::WIDGET_TEMPLATES);
    }
}
