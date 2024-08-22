<?php

namespace App\Modules\Page\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Deprecated;

/**
 * Шаблоны хранятся в папке ;
 */
class Template
{
    const TEMPLATES = [
        'widget' => 'Виджет',
        'page' => 'Страница',
        'service' => 'Услуга',
    ];

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
