<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Entity\Meta;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Setting\Entity\Web;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\Web\Repository\WebRepository;

class EmployeeController extends Controller
{
    private WebRepository $repository;
    private Web $web;

    public function __construct(WebRepository $repository, SettingRepository $settings)
    {
        $this->repository = $repository;
        $this->web = $settings->getWeb();
    }

    public function index()
    {
        $employees = $this->repository->getEmployees();
        $meta = new Meta(params:$this->web->employees);
        return view('web.employee.index', compact('employees', 'meta'));
    }

    public function view(Employee $employee)
    {
        //TODO Переделать на slug ??

        return view('web.employee.show', compact('employee'));
    }
}
