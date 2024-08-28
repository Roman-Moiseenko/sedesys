<?php
declare(strict_types=1);

namespace App\View;

use App\Modules\Setting\Entity\Web;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\Web\Helpers\CacheHelper;
use App\Modules\Web\Helpers\Menu;
use App\Modules\Web\Repository\WebRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use JetBrains\PhpStorm\ArrayShape;

class WebComposer
{
    private WebRepository $repository;
    private Web $web;
    /**
     * @var array[]
     */
    private array $topMenu;

    public function __construct(WebRepository $repository, SettingRepository $settings)
    {
        $this->repository = $repository;
        $this->web = $settings->getWeb();
        $this->topMenu = [];
         //$cache->getCache('menu_top'); //Menu::menuTop();
    }

    public function compose(View $view): void
    {
        //dd($this->repository->getContacts());
        if (!is_null(request()->route())) {
            $pageName = request()->route()->getName();
            $url = request()->url();

            if ($pageName == null) {
                $layout = 'admin';
            } else {
                $layout = (str_contains($pageName, '.')) ? substr($pageName, 0, strpos($pageName, '.')) : 'web';
            }
            if ($layout == 'web') {
                $this->topMenu = Cache::get(CacheHelper::MENU_TOP, function () {
                    return Menu::menuTop();
                });
                $user = (Auth::guard('user')->check()) ? Auth::guard('user')->user() : null;
                $view->with('user', $user);
                $schema = app()->make('\App\Modules\Web\Helpers\Schema');
                $view->with('schema', $schema);
                $view->with('web', $this->web);
                $view->with('menu_top', $this->topMenu);
                $view->with('menu_contact', $this->repository->getContacts());
                $view->with('menu_footer', Menu::menuFooter());
                $view->with('menu_mobile', Menu::menuMobile(!is_null($user)));
                //$view->with('active_menu', $this->activeMenu($pageName));
                $view->with('active_menu', $this->activeMenuByUrl($url));
            }
        }
    }

    private function activeMenu($pageName)
    {
        $firstLevelActiveIndex = '';
        $secondLevelActiveIndex = '';
        $thirdLevelActiveIndex = '';

        foreach ($this->topMenu as $menuKey => $menu) {
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

    #[ArrayShape(['first' => "int|string", 'second' => "int|string", 'third' => "int|string"])]
    private function activeMenuByUrl($currentUrl): array
    {
        $firstLevelActiveIndex = '';
        $secondLevelActiveIndex = '';
        $thirdLevelActiveIndex = '';

        foreach ($this->topMenu as $menuKey => $menu) {
            if ($menu !== 'divider' && isset($menu['url']) && $this->checkUrl($menu, $currentUrl) && empty($firstPageName)) {
                $firstLevelActiveIndex = $menuKey;
            }

            if (isset($menu['submenu'])) {
                foreach ($menu['submenu'] as $subMenuKey => $subMenu) {
                    if (isset($subMenu['url']) && $this->checkUrl($subMenu, $currentUrl) && $menuKey != 'menu-layout' && empty($secondPageName)) {
                        $firstLevelActiveIndex = $menuKey;
                        $secondLevelActiveIndex = $subMenuKey;
                    }

                    if (isset($subMenu['submenu'])) {
                        foreach ($subMenu['submenu'] as $lastSubMenuKey => $lastSubMenu) {
                            if (isset($lastSubMenu['url']) && $this->checkUrl($lastSubMenu, $currentUrl)) {
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

    private function checkUrl($menu, $currentUrl): bool
    {
        return $menu['url'] == $currentUrl;
    }

    private function clearAction($str): string
    {
        if ($str == null) return '';
        $pos = strrpos($str, '.');
        $str = substr($str, 0, $pos);
        return $str;
    }
}
