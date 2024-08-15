<?php

namespace App\Modules\Employee\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Employee\Entity\Employee;

class EmployeeRepository
{

    public function getIndex(Request $request, &$filter): Arrayable
    {
        $query = Employee::orderByDesc('created_at');
        $filter = [];

        if ($request->has('user')) {
            $user = $request->string('user')->trim()->value();
            $filter['user'] = $user;
            $query->where(function ($q) use ($user) {
                $q->orWhere('fullname', 'LIKE', "%$user%")
                    ->orWhere('phone', 'LIKE', "%$user%");
            });
        }
        if ($request->input('draft', 'false') == 'true' ) {
            $filter['draft'] = 'true';
            $query->where('active', false);
        }
        //TODO Тип сотрудника
        if (count($filter) > 0) $filter['count'] = count($filter);

        return $query->paginate($request->input('size', 20))
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
    }

    public function byTelegram(int $telegram_id):? Employee
    {
        return Employee::where('telegram_user_id', $telegram_id)->first();
    }
}
