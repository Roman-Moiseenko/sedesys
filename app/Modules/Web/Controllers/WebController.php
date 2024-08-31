<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Page\Entity\Page;
use Illuminate\Support\Facades\Cache;
use function Ramsey\Uuid\v1;

class WebController extends Controller
{

    public function home()
    {
        if (!is_null($page = Page::where('slug', 'home')->active()->first())) {
            return Cache::rememberForever('page-' . $page->id, function () use ($page) {
                return $page->view();
            });
        } else {
            return Cache::rememberForever('home', function () {
                return view('web.home')->render();
            });
        }
    }

    public function page(string $slug)
    {
        if (!is_null($page = Page::where('slug', $slug)->active()->first())) {
            return Cache::rememberForever('page-' . $page->id, function () use ($page) {
                return $page->view();
            });
        } else {
            abort(404, 'Страница не найдена');
        }
    }
    public function test()
    {
        return view('web.test');
    }
}
