<?php
declare(strict_types=1);


use App\Modules\Base\Entity\Photo;

if (!function_exists('price')) {
    function price($value): string
    {
        if (empty($value) || !is_numeric($value)) return '0 ₽';
        return number_format($value, 0, ',', ' ') . ' ₽';
    }
}

if (!function_exists('phone')) {
    function phone($value): string
    {
        if (empty($value) || !is_numeric($value)) return '';
        return mb_substr($value, 0, 1) . ' ' . mb_substr($value, 1, 3) . '-' . mb_substr($value, 6, 3) . '-' . mb_substr($value, 7, 4);
    }
}

if (!function_exists('modules')) {
    /**
     * Список всех Модулей в приложении
     * @return array
     */
    function modules(): array
    {
        $modules_folder = app_path('Modules');

        return array_values(
            array_filter(
                scandir($modules_folder),
                function ($item) use ($modules_folder) {
                    return is_dir($modules_folder . DIRECTORY_SEPARATOR . $item) && !in_array($item, ['.', '..']);
                }
            )
        );
    }
}

if (!function_exists('modules_callback')){
    /**
     *
     * @param string $file - имя файла в папке Модуля
     * @param callable $callback - функция fn($filePath, $module) обработки для каждого файла $filePath из модуля $module
     * @return void
     */
    function modules_callback(string $file, callable $callback) {
        foreach (modules() as $module) {
            $filePath = app_path('Modules') . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $file;
            if (file_exists($filePath)) {
                $callback($filePath, $module);
            }
        }

    }
}

if (!function_exists('array_select')) {
    function array_select(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $result[] = [
                'value' => $key,
                'label' => $value,
            ];
        }
        return $result;
    }
}

if (!function_exists('photo')) {
    function photo(int $id, string $thumb = 'original'): string
    {
        return Photo::get($id, $thumb);
    }
}

if (!function_exists('photo_std')) {
    function photo_std(int $id, string $thumb = 'original'): stdClass
    {
        /** @var Photo $photo */
        $photo = Photo::find($id);
        $result = new stdClass();
        $result->url = is_null($photo) ? '' : $photo->getThumbUrl($thumb);
        $result->alt = is_null($photo) ? '' : $photo->alt;
        $result->title = is_null($photo) ? '' : $photo->title;
        $result->description = is_null($photo) ? '' : $photo->description;
        return $result;
    }
}
