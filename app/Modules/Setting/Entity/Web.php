<?php
declare(strict_types=1);

namespace App\Modules\Setting\Entity;

use App\Modules\Base\Entity\Meta;

class Web extends AbstractSetting
{
    const META = ['h1' => '', 'title' => '', 'description' => ''];
    const BREADCRUMB = ['photo_id' => 0, 'caption' => '', 'description' => ''];

    public string $name = '';
    public string $short_name = '';
    public bool $auth = false;
    public bool $auth_phone = false;
    public string $menu_icon = 'none'; //icon, awesome
    public bool $use_cache = false; //Кеш для страниц
    public array $use_caches = []; //Кеш для страниц
    //TODO сделать отдельно для каждого типа


    public int $default_breadcrumb_image = 0;

    public array $employees_meta = self::META;
    public array $employees_breadcrumb = self::BREADCRUMB;
    public array $services_meta = self::META;
    public array $services_breadcrumb = self::BREADCRUMB;
    public array $default_meta = self::META;
    public array $default_breadcrumb = self::BREADCRUMB;

    public string $services_awesome = '';
    public string $employees_awesome = '';
    public string $default_awesome = '';

}
