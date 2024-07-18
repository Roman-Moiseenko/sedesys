<?php
declare(strict_types=1);

namespace App\Modules\Employee\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function index()
    {
        return Inertia::render('Employee/Employee/Index');
    }
}
