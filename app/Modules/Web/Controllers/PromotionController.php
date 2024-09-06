<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Entity\BreadcrumbInfo;
use App\Modules\Base\Entity\Meta;
use App\Modules\Discount\Entity\Promotion;
use App\Modules\Setting\Entity\Web;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\Web\Repository\WebRepository;
use Illuminate\Support\Facades\Cache;

class PromotionController extends Controller
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
        return Cache::rememberForever('promotions', function () {
            $promotions = $this->repository->getPromotions();
            $meta = new Meta(params: $this->web->services_meta);
            $breadcrumb = $this->repository->selectBreadcrumb(
                new BreadcrumbInfo(params: $this->web->services_breadcrumb),
                $meta->h1,
            );
            return view('web.promotion.index', compact('promotions', 'meta', 'breadcrumb'))->render();
        });
    }

    public function view($slug)
    {
        $promotion = Promotion::where('slug', $slug)->first();

        return Cache::rememberForever('promotion-' . $promotion->id, function () use ($promotion) {
            if (is_null($promotion)) return abort(404);
            $meta = $promotion->meta;
            $breadcrumb = $this->repository->getBreadcrumbModel($promotion);

            return view('web.promotion.index', compact('meta', 'breadcrumb'))->render();
        });
    }
}
