<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Modules\Employee\Entity\Employee;

class EmployeeController
{
    public function index()
    {

    }

    public function view(Employee $employee)
    {
        return view('web.employee.show', compact('employee'));
    }
}
