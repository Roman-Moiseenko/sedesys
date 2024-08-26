<?php

namespace App\Modules\Employee\Repository;

use App\Modules\Employee\Entity\Specialization;
use App\Modules\Service\Entity\Service;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Employee\Entity\Employee;

class EmployeeRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Employee::orderByDesc('created_at');
        $filters = [];

        if ($request->has('user')) {
            $user = $request->string('user')->trim()->value();
            $filters['user'] = $user;
            $query->where(function ($q) use ($user) {
                $q->orWhere('fullname', 'LIKE', "%$user%")
                    ->orWhere('phone', 'LIKE', "%$user%");
            });
        }
        if ($request->input('draft', 'false') == 'true' ) {
            $filters['draft'] = 'true';
            $query->where('active', false);
        }
        if ($request->has('specialization')) {
            $specialization = $request->integer('specialization');
            $filters['specialization'] = $specialization;
            $query->whereHas('specializations', function ($q) use ($specialization) {
                $q->where('id', $specialization);
            });
        }
        if (count($filters) > 0) $filters['count'] = count($filters);

        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Employee $employee) => [
                'id' => $employee->id,
                'phone' => $employee->phone,
                'fullname' => $employee->fullname->getFullName(),
                'shortname' => $employee->fullname->getShortname(),
                'active' => $employee->active,
                'address' => $employee->address->address,
                'photo' => $employee->getImage('mini'),

                'url' => route('admin.employee.employee.show', $employee),
                'edit' => route('admin.employee.employee.edit', $employee),
                'destroy' => route('admin.employee.employee.destroy', $employee),
                'toggle' => route('admin.employee.employee.toggle', $employee),
            ]);
    }

    public function byTelegram(int $telegram_id):? Employee
    {
        return Employee::where('telegram_user_id', $telegram_id)->first();
    }

    public function getSpecializations(Employee $employee = null)
    {
        $ids = is_null($employee) ? [] : $employee->specializations()->get()->map(function ($item) {
            return $item->id;
        })->toArray();

        return Specialization::get()->map(function (Specialization $specialization) use ($ids) {
            return [
                'id' => $specialization->id,
                'name' => $specialization->name,
                'image' => $specialization->getImage('thumb'),
                'checked' => in_array($specialization->id, $ids),
            ];
        })->toArray();
    }

    public function getSpecializationForFilter()
    {
        return Specialization::orderBy('name')->get()->map(function (Specialization $specialization) {
            return [
                'value' => $specialization->id,
                'label' => $specialization->name,
            ];
        })->toArray();
    }

    public function getActive()
    {
        return Employee::orderBy('fullname')->active()->get();
    }

    public function forFilter()
    {
        return Employee::orderBy('fullname')->get()->map(function (Employee $employee) {
            return [
                'value' => $employee->id,
                'label' => $employee->fullname->getFullName(),
            ];
        })->toArray();
    }

    public function outServices(Employee $employee)
    {
        $ids = $employee->services()->pluck('id')->toArray();

        return Service::whereNotIn('id', $ids)->getModels();
    }

}
