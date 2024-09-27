<?php

namespace App\Modules\Service\Repository;

use App\Modules\Employee\Entity\Employee;
use App\Modules\Service\Entity\Service;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Service\Entity\Example;

class ExampleRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Example::orderByDesc('created_at');
        /**
         * Фильтр, для каждого параметра своя проверка
         */
        $filters = [];
        if ($request->has('title')) {
            $title = $request->string('title')->trim()->value();
            $filters['title'] = $title;
            $query->where('title', 'LIKE', "%$title%");
        }

        if ($request->has('service')) {
            $service_id = $request->integer('service');
            $filters['service'] = $service_id;
            $query->where('service_id', $service_id);
        }

        if ($request->has('employee')) {
            $employee_id = $request->integer('employee');
            $filters['employee'] = $employee_id;
            $query->whereHas('employees', function ($q) use ($employee_id) {
                $q->where('id', $employee_id);
            });
        }

        if (count($filters) > 0) $filters['count'] = count($filters); //Кол-во выбранных элементов в поиске
        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Example $example) => $this->ExampleToArray($example));
    }


    public function getGallery(Example $example): array
    {
        $result = [];
        foreach ($example->gallery as $photo) {
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

    public function getShowByService(Service $service): array
    {
        return $service->examples()->get()->map(function (Example $example) {
            return $this->ExampleToArray($example);
        })->toArray();
    }

    public function getShowByEmployee(Employee $employee): array
    {
        return $employee->examples()->get()->map(function (Example $example) {
            return $this->ExampleToArray($example);
        })->toArray();
    }

    public function ExampleToArray(Example $example): array
    {
        return [
            'id' => $example->id,
            'date' => $example->date->translatedFormat('j F Y'),
            'title' => $example->title,

            'service' => $example->service->name,
            'active' => $example->isActive(),
            'cost' => price($example->cost),
            'employees' => $example->employees,
            'gallery_count' => $example->gallery()->count(),

            //'url' => route('admin.service.example.show', $example),
           // 'edit' => route('admin.service.example.edit', $example),
            'destroy' => route('admin.service.example.destroy', $example),
          //  'toggle' => route('admin.service.example.toggle', $example),
        ];
    }
}
