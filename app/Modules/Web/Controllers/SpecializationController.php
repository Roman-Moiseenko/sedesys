<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Entity\BreadcrumbInfo;
use App\Modules\Base\Entity\Meta;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Setting\Entity\Web;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\Web\Repository\WebRepository;
use Illuminate\Support\Facades\Cache;

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
        return Cache::rememberForever('specializations', function () {
            $specializations = $this->repository->getSpecializations();
            $meta = new Meta(params: $this->web->employees_meta);
            $breadcrumb = $this->repository->selectBreadcrumb(
                new BreadcrumbInfo(params: $this->web->employees_breadcrumb),
                $meta->h1,
            );

            return view('web.specialization.index', compact('specializations', 'meta', 'breadcrumb'))->render();
        });
    }

    public function view($slug)
    {
        $specialization = Specialization::where('slug', $slug)->first();

        return Cache::rememberForever('specialization-' . $specialization->id, function () use ($specialization) {
        if (is_null($specialization)) return abort(404);
        $meta = $specialization->meta;
        $breadcrumb = $this->repository->getBreadcrumbModel($specialization);

        return view('web.specialization.show', compact('specialization', 'meta', 'breadcrumb'))->render();
        });
    }
}
