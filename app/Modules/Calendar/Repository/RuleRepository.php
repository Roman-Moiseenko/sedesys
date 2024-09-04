<?php

namespace App\Modules\Calendar\Repository;

use App\Modules\Calendar\Entity\Regularity;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Service\Entity\Service;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Calendar\Entity\Rule;
use JetBrains\PhpStorm\ArrayShape;

class RuleRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Rule::orderBy('name');
        /**
         * Фильтр, для каждого параметра своя проверка
         */
        $filters = [];
        if ($request->has('name')) {
            $name = $request->string('name')->trim()->value();
            $filters['name'] = $name;
            $query->where('name', 'LIKE', "%$name%");
        }

        if ($request->has('regularity')) {
            $regularity = $request->integer('regularity');
            $filters['regularity'] = $regularity;
            $query->where('regularity', $regularity);
        }
        if ($request->has('service')) {
            $service = $request->integer('service');
            $filters['service'] = $service;
            $query->whereHas('services', function ($q) use ($service) {
                $q->where('id', $service);
            });
        }
        if ($request->has('employee')) {
            $employee = $request->integer('employee');
            $filters['employee'] = $employee;
            $query->whereHas('employees', function ($q) use ($employee) {
                $q->where('id', $employee);
            });
        }


        if (count($filters) > 0) $filters['count'] = count($filters); //Кол-во выбранных элементов в поиске
        $rules = $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Rule $rule) => $this->RuleToArray($rule));

        return $rules;
    }


    #[ArrayShape([
        'id' => "int",
        'name' => "string",
        'regularity' => "string",
        'services' => "array|null",
        'employees' => "array|null",
        'max' => "int",
        'active' => "boolean",
        'url' => "string",
        'edit' => "string",
        'destroy' => "string",
        'toggle' => "string"
    ])]
    public function RuleToArray(Rule $rule): array
    {
        return [
            'id' => $rule->id,
            'name' => $rule->name,
            'regularity' => Regularity::REPEAT_DAYS[$rule->regularity],
            'services' => $rule->services()->get()->map(function (Service $service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                ];
            })->toArray(),
            'employees' => $rule->employees()->get()->map(function (Employee $employee) {
                return [
                    'id' => $employee->id,
                    'name' => $employee->fullname->getFullName(),
                ];
            })->toArray(),
            'max' => $rule->max,
            'active' => $rule->isActive(),
            'url' => route('admin.calendar.rule.show', $rule),
            'edit' => route('admin.calendar.rule.edit', $rule),
            'destroy' => route('admin.calendar.rule.destroy', $rule),
            'toggle' => route('admin.calendar.rule.toggle', $rule),
        ];
    }

    public function getRegularities(): array
    {
        return array_select(Regularity::REPEAT_DAYS);
    }
}
