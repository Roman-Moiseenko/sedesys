<?php

namespace App\Modules\Page\Entity;

use App\Modules\Base\Entity\DisplayedModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Deprecated;

/**
 * Шаблоны хранятся в папке ;
 */
class Template
{
   /* const TEMPLATES = [
        'widget' => 'Виджет',
        'page' => 'Страница',
        'service' => 'Услуга',
        'specialization' => 'Специализация',
        'classification' => 'Классификация',
        'employee' => 'Персонал',
    ];*/

    /**
     * Собираем все шаблоны в один массив
     * @return array
     */
    public static function TEMPLATES(): array
    {
        $base['widget'] = 'Виджет';
        foreach (DisplayedModel::LIST_MODELS as $key => $name) {
            $base[strtolower(class_basename($key))] = $name;
        }
        return $base;
    }

    public static function TEMPLATE_NAME($type): string
    {
        return self::TEMPLATES()[$type];
    }

    /**
     * Папка с шаблонами по виду
     * @param string $type
     * @return string
     */
    public static function Path(string $type): string
    {
        return resource_path() . '/views/web/templates/' . $type . '/';
    }

    /**
     * Путь к файлу blade шаблона
     * @param string $type - вид шаблона
     * @param string $template - шаблон
     * @return string - файл $template.blade.php
     */
    public static function File(string $type, string $template): string
    {
        return self::Path($type) . $template . '.blade.php';
    }

    /**
     * Путь к файлу Stub базовый шаблон по виду
     * @param string $type - вид шаблона
     * @return string - файл $type.stub
     */
    public static function Base(string $type): string
    {
        return resource_path('views/web/templates/base/'. $type . '.stub');
    }
}
