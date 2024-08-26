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

    //public array $specializations = self::META;
    public array $employees = self::META;
    //public array $classifications = self::META;
    public array $services = self::META;

    //['h1' => '', 'title' => '', 'description' => ''];
}
