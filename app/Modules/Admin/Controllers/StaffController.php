<?php
declare(strict_types=1);

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Entity\Admin;
use Inertia\Inertia;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Admin::getModels();
        return Inertia::render('Admin/Staff/Index', [
            'staff'=> $staffs
        ]);
    }
}
