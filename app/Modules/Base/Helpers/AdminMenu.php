<?php
declare(strict_types=1);

namespace App\Modules\Base\Helpers;

class AdminMenu
{
    public static function menu(): array
    {
        $menus = [];

        modules_callback('menus.php', function ($filePath) use (&$menus) {
            $menus = array_merge($menus, include $filePath);
        });

        uasort($menus, function ($a, $b) {
            return $a['sort'] > $b['sort'];
        });
        return $menus;
    }

}
