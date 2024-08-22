<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Service\Entity\Classification;
use App\Modules\Web\Repository\WebRepository;

class ClassificationController extends Controller
{
    private WebRepository $repository;

    public function __construct(WebRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $classifications = $this->repository->getRootClassifications();
        return view('web.classification.index', compact('classifications'));
    }

    public function view($slug)
    {
        $classification = Classification::where('slug', $slug)->first();
        if (is_null($classification)) return abort(404);

        if (count($classification->children) > 0) return view('web.classification.show', compact('classification'));

        $services = $classification->services;

        return view('web.service.index', compact('services'));
    }
}
