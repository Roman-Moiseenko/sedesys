<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Web\Repository\WebRepository;

class SpecializationController
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

    public function view(Specialization $specialization)
    {
        return view('web.specialization.show', compact('specialization'));
    }
}
