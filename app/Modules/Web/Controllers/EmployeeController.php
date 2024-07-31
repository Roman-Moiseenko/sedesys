<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Modules\Employee\Entity\Employee;
use App\Modules\Web\Repository\WebRepository;

class EmployeeController
{
    private WebRepository $repository;

    public function __construct(WebRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $employees = $this->repository->getEmployees();
        return view('web.employee.index', compact('employees'));
    }

    public function view(Employee $employee)
    {
        return view('web.employee.show', compact('employee'));
    }
}
