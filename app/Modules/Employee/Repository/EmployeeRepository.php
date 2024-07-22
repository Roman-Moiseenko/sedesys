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
            ->paginate(20)->withQueryString()
            ->through(fn(Employee $employee) => [
                'id' => $employee->id,
                'phone' => $employee->phone,
                'fullname' => $employee->fullname->getFullName(),
                'shortname' => $employee->fullname->getShortname(),
                'active' => $employee->active,

                'url' => route('admin.employee.employee.show', $employee),
                'edit' => route('admin.employee.employee.edit', $employee),
                'destroy' => route('admin.employee.employee.destroy', $employee),
            ]);

        return $employees;
    }
}
