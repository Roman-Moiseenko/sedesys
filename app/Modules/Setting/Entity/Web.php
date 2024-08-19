<?php
declare(strict_types=1);

namespace App\Modules\Setting\Entity;

class Web extends AbstractSetting
{
    public string $name = '';
    public string $short_name = '';
    public bool $auth = false;
    public bool $auth_phone = false;
}
