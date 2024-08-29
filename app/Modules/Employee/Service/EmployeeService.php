<?php

namespace App\Modules\Employee\Service;

use App\Modules\Base\Entity\FullName;
use App\Modules\Base\Entity\Photo;
use App\Modules\Service\Entity\Service;
use Illuminate\Http\Request;
use App\Modules\Employee\Entity\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeService
{

    public function create(Request $request): Employee
    {
        $employee = Employee::employee(
            (string)$request->string('surname'),
            (string)$request->string('firstname'),
            (string)$request->string('secondname')
        );
        $this->save_fields($employee, $request);
        return  $employee;
    }

    public function update(Employee $employee, Request $request)
    {
        $employee->fullname = new FullName(
            (string)$request->string('surname'),
            (string)$request->string('firstname'),
            (string)$request->string('secondname')
        );
        $employee->save();

        $this->save_fields($employee, $request);
    }

    private function save_fields(Employee $employee, Request $request)
    {
        $employee->saveDisplayed($request);

        $employee->telegram_user_id = $request->integer('telegram_user_id');
        $employee->phone = (string)$request->string('phone');
        if ($request->has('password')) {
            $employee->password = Hash::make((string)$request->string('password'));
        }
        $employee->address->address = (string)$request->string('address');
        $employee->experience_year = $request->input('experience_year');
        $employee->save();


        $employee->specializations()->detach();
        $specializations = $request->input('specializations', []);

        foreach ($specializations as $specialization) {
            $employee->specializations()->attach($specialization);
        }

        $employee->save();
    }


    public function destroy(Employee $employee)
    {
        /**
         * Проверить на возможность удаления
         */
        $employee->delete();
    }

    public function password(Employee $employee, Request $request)
    {
        $employee->password = Hash::make((string)$request->string('password'));
        $employee->save();
    }

    public function attach_service(Employee $employee, Request $request)
    {
        //TODO Проверить есть уже или нет.
        $service = Service::find($request->integer('service_id'));
        $employee->services()
            ->attach(
                $service->id,
                ['extra_cost' => $request->integer('extra_cost', null)]
            );
        return $service;
    }

    public function detach_service(Employee $employee, Request $request)
    {

        $service = Service::find($request->integer('service_id'));
        $employee->services()->detach($service->id);
        return $service;
    }
}
