<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Entity\BreadcrumbInfo;
use App\Modules\Base\Entity\Meta;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Setting\Entity\Web;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\Web\Repository\WebRepository;
use Illuminate\Support\Facades\Cache;

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
        $callback = function () {
            $employees = $this->repository->getEmployees();
            $meta = new Meta(params: $this->web->employees_meta);
            $breadcrumb = $this->repository->selectBreadcrumb(
                new BreadcrumbInfo(params: $this->web->employees_breadcrumb),
                $meta->h1,
            );
            return view('web.employee.index', compact('employees', 'meta', 'breadcrumb'))->render();
        };

        if (in_array('employee', $this->web->use_caches)) {
            return Cache::rememberForever('employees', $callback);
        } else {
            return $callback();
        }
    }

    public function view($slug)
    {
        if (is_null($employee = Employee::where('slug', $slug)->first())) abort(404);

        $callback = function () use ($employee) {
            return $employee->view();
        };

        if (in_array('employee', $this->web->use_caches)) {
            return Cache::rememberForever('employee-' . $employee->id, $callback);
        } else {
            return $callback();
        }
    }
}
