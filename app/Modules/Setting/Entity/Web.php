<?php
declare(strict_types=1);

namespace App\Modules\Setting\Entity;

use App\Modules\Base\Entity\Meta;

class Web extends AbstractSetting
{
    const META = ['h1' => '', 'title' => '', 'description' => ''];
    public string $name = '';
    public string $short_name = '';
    public bool $auth = false;
    public bool $auth_phone = false;
    public string $menu_icon = 'none'; //icon, awesome
    public int $default_breadcrumb_image = 0;

    //public array $specializations = self::META;
    public array $employees = self::META;
    public int $employees_breadcrumb_image = 0;
    //public array $classifications = self::META;
    public array $services = self::META;
    public int $services_breadcrumb_image = 0;

    //['h1' => '', 'title' => '', 'description' => ''];
}
