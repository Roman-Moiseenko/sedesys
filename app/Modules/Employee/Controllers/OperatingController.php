<?php

namespace App\Modules\Employee\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Operating;
use App\Modules\Employee\Requests\OperatingRequest;
use App\Modules\Employee\Resources\OperatingResource;
use App\Modules\Employee\Service\OperatingService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;

class OperatingController extends Controller
{

    private OperatingService $service;

    public function __construct(OperatingService $service)
    {
        $this->service = $service;
    }


    public function index(Request $request)
    {

        return Inertia::render('Employee/Operating/Index', [

            ]
        );
    }

}
