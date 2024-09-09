<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Entity\BreadcrumbInfo;
use App\Modules\Base\Entity\Meta;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Page\Entity\Widget;
use App\Modules\Service\Entity\Classification;
use App\Modules\Service\Entity\Service;
use App\Modules\Setting\Entity\Web;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\Web\Repository\WebRepository;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
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
        $callback = function () {
            $services = $this->repository->getServices();
            $meta = new Meta(params: $this->web->services_meta);
            $breadcrumb = $this->repository->selectBreadcrumb(
                new BreadcrumbInfo(params: $this->web->services_breadcrumb),
                $meta->h1,
            );
            return view('web.service.index', compact('services', 'meta', 'breadcrumb'))->render();
        };

        if (in_array('service', $this->web->use_caches)) {
            return Cache::rememberForever('services', $callback);
        } else {
            return $callback();
        }
    }

    public function view($slug)
    {
        /** @var Service $service */
        $service = Service::where('slug', $slug)->first();
        if (is_null($service)) return abort(404);

        $callback = function () use ($service) {
            return $service->view();
        };

        if (in_array('service', $this->web->use_caches)) {
            return Cache::rememberForever('service-' . $service->id, $callback);
        } else {
            return $callback();
        }

    }

}
