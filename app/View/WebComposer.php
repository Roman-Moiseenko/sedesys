<?php
declare(strict_types=1);

namespace App\View;

use App\Modules\Web\Helpers\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WebComposer
{

    public function compose(View $view): void
    {
        if (!is_null(request()->route())) {
            $pageName = request()->route()->getName();
            if ($pageName == null) {
                $layout = 'admin';
            } else {
                $layout = (str_contains($pageName, '.')) ? substr($pageName, 0, strpos($pageName, '.')) : 'web';
            }
            //$activeMenu = $this->activeMenu($pageName, $layout);

            if ($layout == 'web') {
                $user = (Auth::guard('user')->check()) ? Auth::guard('user')->user() : null;
                $view->with('user', $user);
                //TODO Подключить
                //$view->with('schema', new Schema());

                $view->with('menu_top', Menu::menuTop());
                $view->with('menu_contact', Menu::menuContact());
                $view->with('menu_footer', Menu::menuFooter());
                $view->with('menu_mobile', Menu::menuMobile(!is_null($user)));
            }



        }
    }
}
