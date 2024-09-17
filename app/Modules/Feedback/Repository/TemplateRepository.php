<?php

namespace App\Modules\Feedback\Repository;

use App\Modules\Admin\Entity\Admin;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Feedback\Entity\Template;
use JetBrains\PhpStorm\ExpectedValues;

class TemplateRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Template::orderBy('name');
        /**
         * Фильтр, для каждого параметра своя проверка
         */
        $filters = [];
        if ($request->has('name')) {
            $name = $request->string('name')->trim()->value();
            $filters['name'] = $name;
            $query->where('name', 'LIKE', "%$name%");
        }

        if (count($filters) > 0) $filters['count'] = count($filters); //Кол-во выбранных элементов в поиске
        $templates = $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Template $template) => $this->TemplateToArray($template));

        return $templates;
    }


    public function TemplateToArray(Template $template): array
    {
        return [
            'id' => $template->id,
            'name' => $template->name,
            'color' => $template->color,
            'template' => $template->template,
            'active' => $template->isActive(),

            'url' => route('admin.feedback.template.show', $template),
            'toggle' => route('admin.feedback.template.toggle', $template),
            'edit' => route('admin.feedback.template.edit', $template),
            'destroy' => route('admin.feedback.template.destroy', $template),

        ];
    }

    public function TemplateWithToArray(Template $template): array
    {
        $withData = [
            /**
             * Данные из relations
             */
        ];

        return array_merge($this->TemplateToArray($template), $withData);
    }

    public function forFilter()
    {
        return Template::orderBy('name')->get()->map(fn(Template $template) => [
            'id' => $template->id,
            'name' => $template->name,
        ])->toArray();
    }
}