<?php

namespace App\Modules\Employee\Service;

use App\Modules\Base\Entity\FullName;
use App\Modules\Base\Entity\Photo;
use Illuminate\Http\Request;
use App\Modules\Employee\Entity\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeService
{

    public function create(Request $request): Employee
    {
        $employee = Employee::register(
            (string)$request->string('phone'),
            (string)$request->string('password')
        );

        $this->save_fields($employee, $request);
        $employee->refresh();
        return  $employee;
    }

    public function update(Employee $employee, Request $request)
    {
        $employee->phone = (string)$request->string('phone');

        if ($request->has('password')) {
            $employee->password = Hash::make((string)$request->string('password'));
        }

        if ($request->boolean('clear_file') && !is_null($employee->photo)) {
            $employee->photo->delete();
        }
        $employee->save();


        $this->save_fields($employee, $request);
    }

    private function save_fields(Employee $employee, Request $request)
    {
        $employee->telegram_user_id = $request->integer('telegram_user_id');

        $employee->fullname = new FullName(
            (string)$request->string('surname'),
            (string)$request->string('firstname'),
            (string)$request->string('secondname')
        );
        $employee->experience_year = $request->input('experience_year');
        $employee->save();
        $employee->address->address = (string)$request->string('address');

        $this->photo($employee, $request->file('file'));

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

    public function photo(Employee $employee, $file): void
    {
        if (empty($file)) return;
        if (!empty($employee->photo)) {
            $employee->photo->newUploadFile($file);
        } else {
            $employee->photo()->save(Photo::upload($file));
        }
        $employee->refresh();
    }

    public function password(Employee $employee, Request $request)
    {
        $employee->password = Hash::make((string)$request->string('password'));
        $employee->save();
    }

    public function attach(Employee $employee, Request $request)
    {
        $employee->specializations()->detach();
        $specializations = $request->input('specializations', []);
        foreach ($specializations as $specialization) {
            $employee->specializations()->attach($specialization);
        }
    }
}
