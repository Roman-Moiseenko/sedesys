<?php

namespace App\Modules\Employee\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Employee\Entity\Employee;

class EmployeeRepository
{

    public function getIndex(Request $request): Arrayable
    {
        $employees = Employee::orderByDesc('created_at')
            ->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Employee $employee) => [
                'id' => $employee->id,
                'phone' => $employee->phone,
                'fullname' => $employee->fullname->getFullName(),
                'shortname' => $employee->fullname->getShortname(),
                'active' => $employee->active,
                'address' => $employee->address->address,

                'url' => route('admin.employee.employee.show', $employee),
                'edit' => route('admin.employee.employee.edit', $employee),
                'destroy' => route('admin.employee.employee.destroy', $employee),
                'toggle' => route('admin.employee.employee.toggle', $employee),
            ]);

        return $employees;
    }
}
