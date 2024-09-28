<?php

namespace App\Modules\Page\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Widget;

class WidgetRepository
{
    private TemplateRepository $templateRepository;

    public function __construct(TemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
    }

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
            ]);
    }

    public function getModels(): array
    {
        return array_select(Widget::WIDGET_MODELS);
    }

    public function getTemplates(): array
    {
        $list = $this->templateRepository->getDataArray('widget');
        $result = [];
        foreach ($list as $item) {
            $result[] = [
                'value' => $item['template'],
                'label' => $item['name'],
            ];
        }
        return $result;//array_select(Widget::WIDGET_TEMPLATES);
    }
}
