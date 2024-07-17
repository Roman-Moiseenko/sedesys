<?php
declare(strict_types=1);

namespace App\Modules\Base\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['auth:admin']);
    }

    public function index(): \Inertia\Response
    {
        return Inertia::render('Home', [

        ]);
    }
}
