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
            if ($layout == 'web') {
                $user = (Auth::guard('user')->check()) ? Auth::guard('user')->user() : null;
                $view->with('user', $user);
                //TODO Подключить
                //$view->with('schema', new Schema());

                $view->with('menu_top', Menu::menuTop());
                $view->with('menu_contact', Menu::menuContact());
                $view->with('menu_footer', Menu::menuFooter());
                $view->with('menu_mobile', Menu::menuMobile(!is_null($user)));
                $view->with('active_menu', $this->activeMenu($pageName));
            }
        }
    }

    private function activeMenu($pageName)
    {
        $firstLevelActiveIndex = '';
        $secondLevelActiveIndex = '';
        $thirdLevelActiveIndex = '';

        foreach (Menu::menuTop() as $menuKey => $menu) {
            if ($menu !== 'divider' && isset($menu['route']) && $this->checkRouteName($menu, $pageName) && empty($firstPageName)) {
                $firstLevelActiveIndex = $menuKey;
            }

            if (isset($menu['submenu'])) {
                foreach ($menu['submenu'] as $subMenuKey => $subMenu) {
                    if (isset($subMenu['route']) && $this->checkRouteName($subMenu, $pageName) && $menuKey != 'menu-layout' && empty($secondPageName)) {
                        $firstLevelActiveIndex = $menuKey;
                        $secondLevelActiveIndex = $subMenuKey;
                    }

                    if (isset($subMenu['submenu'])) {
                        foreach ($subMenu['submenu'] as $lastSubMenuKey => $lastSubMenu) {
                            if (isset($lastSubMenu['route']) && $this->checkRouteName($lastSubMenu, $pageName)) {
                                $firstLevelActiveIndex = $menuKey;
                                $secondLevelActiveIndex = $subMenuKey;
                                $thirdLevelActiveIndex = $lastSubMenuKey;
                            }
                        }
                    }
                }
            }
        }
        return [
            'first' => $firstLevelActiveIndex,
            'second' => $secondLevelActiveIndex,
            'third' => $thirdLevelActiveIndex
        ];
    }


    private function checkRouteName($menu, $pageName): bool
    {
        if (isset($menu['action'])) return $menu['route'] == $pageName;
        return $this->clearAction($menu['route']) == $this->clearAction($pageName);
    }

    private function clearAction($str): string
    {
        if ($str == null) return '';
        $pos = strrpos($str, '.');
        $str = substr($str, 0, $pos);
        return $str;
    }
}
