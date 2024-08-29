<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Entity\BreadcrumbInfo;
use App\Modules\Base\Entity\Meta;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Service\Entity\Classification;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\Web\Repository\WebRepository;
use Illuminate\Support\Facades\Cache;

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
        return Cache::rememberForever('classifications', function () {
            $classifications = $this->repository->getRootClassifications();
            $meta = new Meta(params: $this->web->services_meta);
            $breadcrumb = $this->repository->selectBreadcrumb(
                new BreadcrumbInfo(params: $this->web->services_breadcrumb),
                $meta->h1,
            );
            return view('web.classification.index', compact('classifications', 'meta', 'breadcrumb'))->render();
        });
    }

    public function view($slug)
    {
        $classification = Classification::where('slug', $slug)->first();

        return Cache::rememberForever('classification-' . $classification->id, function () use ($classification) {
            if (is_null($classification)) return abort(404);
            $meta = $classification->meta;
            $breadcrumb = $this->repository->getBreadcrumbModel($classification);
            if (count($classification->children) > 0) {
                return view('web.classification.show', compact('classification', 'meta', 'breadcrumb'))->render();
            }
            $services = $classification->services;
            return view('web.service.index', compact('services', 'meta', 'breadcrumb'))->render();
        });
    }
}
