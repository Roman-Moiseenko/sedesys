<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Entity\Meta;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Service\Entity\Classification;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\Web\Repository\WebRepository;

class ClassificationController extends Controller
{
    private WebRepository $repository;
    private \App\Modules\Setting\Entity\Web $web;

    public function __construct(WebRepository $repository, SettingRepository $settings)
    {
        $this->repository = $repository;
        $this->web = $settings->getWeb();
    }

    public function index()
    {
        $classifications = $this->repository->getRootClassifications();
        $meta = new Meta(params:$this->web->services);
        return view('web.classification.index', compact('classifications', 'meta'));
    }

    public function view($slug)
    {
        $classification = Classification::where('slug', $slug)->first();
        if (is_null($classification)) return abort(404);
        $meta = $classification->meta;
        //dd(count($classification->children));
        if (count($classification->children) > 0)
            return view('web.classification.show', compact('classification', 'meta'));

        $services = $classification->services;
        return view('web.service.index', compact('services', 'meta'));
    }
}
