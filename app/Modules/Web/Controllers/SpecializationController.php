<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Web\Repository\WebRepository;

class SpecializationController extends Controller
{
    private WebRepository $repository;

    public function __construct(WebRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $specializations = $this->repository->getSpecializations();

        return view('web.specialization.index', compact('specializations'));
    }

    public function view($slug)
    {
        $specialization = Specialization::where('slug', $slug)->first();
        if (is_null($specialization)) return abort(404);
        $meta = $specialization->meta;
        return view('web.specialization.show', compact('specialization', 'meta'));
    }
}
