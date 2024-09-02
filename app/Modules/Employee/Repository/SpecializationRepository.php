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
                'count_employees' => $specialization->employees()->count(),
                'active' => $specialization->isActive(),
                'employees' => $specialization->employees()->get()->map(
                    function (Employee $employee) use ($specialization) {
                        return [
                            'id' => $employee->id,
                            'fullname' => $employee->fullname->getFullName(),
                            'phone' => $employee->phone,
                            'photo' => $employee->getImage('mini'),
                            'detach' => route('admin.employee.specialization.detach', $specialization),
                            'url' => route('admin.employee.employee.show', $employee),
                        ];
                    }
                )->toArray(),

                'url' => route('admin.employee.specialization.show', $specialization),
                'edit' => route('admin.employee.specialization.edit', $specialization),
                'destroy' => route('admin.employee.specialization.destroy', $specialization),
                'toggle' => route('admin.employee.specialization.toggle', $specialization),
                'up' => route('admin.employee.specialization.up', $specialization),
                'down' => route('admin.employee.specialization.down', $specialization),
            ]);
    }


    public function getEmployees(Specialization $specialization = null)
    {
        if (is_null($specialization)) {
            $ids = [];
        } else {
            $ids = $specialization->employees()->get()->map(function ($item) {
                return $item->id;
            })->toArray();
        }
        return Employee::orderBy('fullname')->get()->map(function (Employee $employee) use ($ids) {
            return [
                'id' => $employee->id,
                'fullname' => $employee->fullname->getFullName(),
                'phone' => $employee->phone,
                'photo' => $employee->getImage('mini'),
                'checked' => in_array($employee->id, $ids),
            ];
        })->toArray();
    }

    public function getShowByEmployee(Employee $employee): array
    {
        return $employee->specializations()->get()->map(function (Specialization $specialization) {
            return [
                'name' => $specialization->name,
                'icon' => $specialization->getIcon('thumb'),
            ];
        })->toArray();
    }

    public function getShow(int $id): Specialization
    {
        return Specialization::where('id', $id)->with('employees')->first();
    }


}
