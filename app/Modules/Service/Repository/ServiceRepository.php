<?php

namespace App\Modules\Service\Repository;

use App\Modules\Employee\Entity\Employee;
use App\Modules\Page\Repository\TemplateRepository;
use App\Modules\Service\Entity\Classification;
use App\Modules\Service\Entity\Extra;
use App\Modules\Service\Entity\Review;
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
        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Service $service) => $this->ServiceToArray($service));
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

    public function getShow(int $id): Service
    {
        return  Service::where('id', $id)
            ->with('classification')
            ->with('employees')
            ->with('employees.specializations')
            ->with('examples')
            ->first();
    }

    public function outEmployees(Service $service)
    {
        $ids = $service->employees()->pluck('id')->toArray();

        return Employee::whereNotIn('id', $ids)->getModels();
    }

    public function getActive()
    {
        return Service::orderBy('name')->active()->getModels();
    }

    public function forFilter()
    {
        return Service::orderBy('name')->get()->map(function (Service $service) {
            return [
                'value' => $service->id,
                'label' => $service->name,
            ];
        })->toArray();
    }

    public function getShowByClassification(Classification $classification): array
    {
        return $classification->services()->get()->map(function (Service $service) {
            return $this->ServiceToArray($service);
        })->toArray();
    }

    public function getShowByEmployee(Employee $employee): array
    {
        return $employee->services()->get()->map(function (Service $service) use ($employee) {
            $array = $this->ServiceToArray($service);
            $array['extra_cost'] = $service->pivot->extra_cost;
            return  $array;
        })->toArray();
    }

    public function ServiceToArray(Service $service): array
    {
        return [
            'id' => $service->id,
            'name' => $service->name,
            'price' => price($service->price),
            'duration' => duration($service->duration),
            'active' => $service->isActive(),
            'classification' => $service->getClassificationName(),
            'count_employees' => $service->employees()->count(),
            'image' => $service->getImage('mini'),
            'icon' => $service->getIcon('mini'),

            'url' => route('admin.service.service.show', $service),
            'edit' => route('admin.service.service.edit', $service),
            'destroy' => route('admin.service.service.destroy', $service),
            'toggle' => route('admin.service.service.toggle', $service),
        ];
    }

    public function getReviews(Service $service): array
    {
        return $service->reviews()->get()->map(fn(Review $review) => [
            'from' => $review->getFrom(),
            'rating' => $review->rating,
            'text' => $review->text,
            'employee' => !is_null($review->employee_id) ? $review->employee->fullname->getFullName() : '',
            'created_at' => $review->created_at->translatedFormat('j F Y'),
        ])->toArray();
    }

    public function getExtras(Service $service): array
    {
        return $service->extras()->get()->map(fn(Extra $extra) => [
            'name' => $extra->name,
            'description' => $extra->description,
            'price' => $extra->price,
            'duration' => $extra->duration,
            'awesome' => $extra->awesome,
            'icon' => $extra->getIcon(),
            'active' => $extra->isActive(),

            'toggle' => route('admin.service.extra.toggle', $extra),
            'up' => route('admin.service.extra.up', $extra),
            'down' => route('admin.service.extra.down', $extra),
            'update' => route('admin.service.extra.update', $extra),
            'destroy' => route('admin.service.extra.destroy', $extra),
        ])->toArray();
    }
}
