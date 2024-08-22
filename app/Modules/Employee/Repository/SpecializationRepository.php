<?php

namespace App\Modules\Employee\Repository;

use App\Modules\Employee\Entity\Employee;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Employee\Entity\Specialization;

class SpecializationRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Specialization::orderBy('sort');

        $filters = [];
        if ($request->has('name')) {
            $name = $request->string('name')->trim()->value();
            $filters['name'] = $name;
            $query->where('name', 'LIKE', "%$name%");
        }
        if (count($filters) > 0) $filters['count'] = count($filters); //Кол-во выбранных элементов в поиске

        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Specialization $specialization) => [
                'id' => $specialization->id,
                'name' => $specialization->name,
                'slug' => $specialization->slug,
                'meta' => $specialization->meta,
                'image' => $specialization->getImage('mini'),
                'icon' => $specialization->getIcon('mini'),
                'employees' => $specialization->employees()->count(),
                'active' => $specialization->isActive(),

                'url' => route('admin.employee.specialization.show', $specialization),
                'edit' => route('admin.employee.specialization.edit', $specialization),
                'destroy' => route('admin.employee.specialization.destroy', $specialization),
                'toggle' => route('admin.employee.specialization.toggle', $specialization),
                'up' => route('admin.employee.specialization.up', $specialization),
                'down' => route('admin.employee.specialization.down', $specialization),
            ]);
    }


    public function getEmployees(Specialization $specialization)
    {

        $ids = $specialization->employees()->get()->map(function ($item) {
            return $item->id;
        })->toArray();

        return Employee::get()->map(function (Employee $employee) use ($ids) {
            return [
                'id' => $employee->id,
                'fullname' => $employee->fullname->getFullName(),
                'phone' => $employee->phone,
                'photo' => $employee->getImage('thumb'),
                'checked' => in_array($employee->id, $ids),
            ];
        })->toArray();
    }
}
