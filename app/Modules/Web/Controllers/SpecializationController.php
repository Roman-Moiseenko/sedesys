<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Entity\Meta;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Setting\Entity\Web;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\Web\Repository\WebRepository;

class SpecializationController extends Controller
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
        $specializations = $this->repository->getSpecializations();
        //TODO Перенести в настройки
        $meta = new Meta(params:$this->web->employees);

        return view('web.specialization.index', compact('specializations', 'meta'));
    }

    public function view($slug)
    {
        $specialization = Specialization::where('slug', $slug)->first();
        if (is_null($specialization)) return abort(404);
        $meta = $specialization->meta;
        return view('web.specialization.show', compact('specialization', 'meta'));
    }
}
