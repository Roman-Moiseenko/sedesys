<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Page\Entity\Page;
use App\Modules\Page\Entity\Widget;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\Web\Repository\WebRepository;
use Illuminate\Support\Facades\Cache;
use function Ramsey\Uuid\v1;

class WebController extends Controller
{

    private WebRepository $repository;
    private \App\Modules\Setting\Entity\Web $web;

    public function __construct(WebRepository $repository, SettingRepository $settings)
    {
        $this->repository = $repository;
        $this->web = $settings->getWeb();
    }

    public function home()
    {
        if (!is_null($page = Page::where('slug', 'home')->active()->first())) {
            $callback = function () use ($page) {
                return $page->view();
            };
        } else {
            $callback = function () {
                return view('web.home')->render();
            };
        }
        if (in_array('page', $this->web->use_caches)) {
            return Cache::rememberForever('home' . $page->id, $callback);
        } else {
            return $callback();
        }
    }

    public function page(string $slug)
    {
        if (!is_null($page = Page::where('slug', $slug)->active()->first())) {
            $callback = function () use ($page) {
                return $page->view();
            };

            if (in_array('page', $this->web->use_caches)) {
                return Cache::rememberForever('page-' . $page->id, $callback);
            } else {
                return $callback();
            }

        } else {
            abort(404, 'Страница не найдена');
        }
    }

    public function test()
    {
        return view('web.test');
    }
}
