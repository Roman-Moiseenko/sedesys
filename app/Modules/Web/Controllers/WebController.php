<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Page\Entity\Page;
use function Ramsey\Uuid\v1;

class WebController extends Controller
{

    public function home()
    {
        if (!is_null($page = Page::where('slug', 'home')->where('published', true)->first())) {
            return $page->view();
        } else {
            return view('web.home');
        }
    }

    public function page(string $slug)
    {
        if (!is_null($page = Page::where('slug', $slug)->where('published', true)->first())) {
            return $page->view();
        } else {
            abort(404, 'Страница не найдена');
        }
    }
    public function test()
    {
        return view('web.test');
    }
}
