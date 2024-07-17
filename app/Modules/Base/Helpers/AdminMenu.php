<?php
declare(strict_types=1);

namespace App\Modules\Base\Helpers;

class AdminMenu
{
    public static function menu(): array
    {
        $modules_folder = app_path('Modules');
        $modules = self::getModulesList($modules_folder);

        $menus = [];
        foreach ($modules as $module) {
            $menusPath = $modules_folder . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'menus.php';

            if (file_exists($menusPath)) {
                $menus = array_merge($menus, include $menusPath);
            }
        }
        return $menus;
    }



    private static function getModulesList(string $modules_folder): array
    {
        return
            array_values(
                array_filter(
                    scandir($modules_folder),
                    function ($item) use ($modules_folder) {
                        return is_dir($modules_folder . DIRECTORY_SEPARATOR . $item) && !in_array($item, ['.', '..']);
                    }
                )
            );
    }
}
