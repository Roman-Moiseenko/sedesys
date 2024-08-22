<?php

namespace App\Modules\Service\Repository;

use App\Modules\Page\Repository\TemplateRepository;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Service\Entity\Service;

class ServiceRepository
{
    private TemplateRepository $templateRepository;

    public function __construct(TemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
    }

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Service::orderBy('name');
        $filters = [];
        if ($request->has('name')) {
            $name = $request->string('name')->trim()->value();
            $filters['name'] = $name;
            $query->where('name', 'LIKE', "%$name%");
        }
        if ($request->has('classification')) {
            $classification = $request->integer('classification');
            $filters['classification'] = $classification;
            $query->where('classification_id', $classification);
        }
        if ($request->has('template')) {
            $template = $request->string('template')->trim()->value();
            $filters['template'] = $template;
            $query->where('template', $template);
        }
        if ($request->input('draft', 'false') == 'true' ) {
            $filters['draft'] = 'true';
            $query->where('active', false);
        }

        if (count($filters) > 0) $filters['count'] = count($filters); //Кол-во выбранных элементов в поиске
        $services = $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Service $service) => [
                'id' => $service->id,
                'name' => $service->name,
                'price' => price($service->price),
                'duration' => $service->getDurationText(),
                'active' => $service->isActive(),
                'classification' => $service->getClassificationName(),

                /**

                 */
                'employees' => -1,

                'url' => route('admin.service.service.show', $service),
                'edit' => route('admin.service.service.edit', $service),
                'destroy' => route('admin.service.service.destroy', $service),
                'toggle' => route('admin.service.service.toggle', $service),

            ]);

        return $services;
    }

    public function getTemplates(): array
    {
        $list = $this->templateRepository->getDataArray('service');
        $result = [];
        foreach ($list as $item) {
            $result[] = [
                'value' => $item['template'],
                'label' => $item['name'],
            ];
        }

        return $result;
    }

    public function getGallery(Service $service): array
    {
        $result = [];
        foreach ($service->gallery as $photo) {
            $result[] = [
                'id' => $photo->id,
                'name' => $photo->file,
                'url' => $photo->getThumbUrl('original'),
                'alt' => $photo->alt,
                'title' => $photo->title,
                'description' => $photo->description,
            ];
        }
        return $result;
    }
}
