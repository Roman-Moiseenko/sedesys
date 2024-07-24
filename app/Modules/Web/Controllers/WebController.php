<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use function Ramsey\Uuid\v1;

class WebController extends Controller
{

    public function home()
    {
        return view('web.home');
    }
}
