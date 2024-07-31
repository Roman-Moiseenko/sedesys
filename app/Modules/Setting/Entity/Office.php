<?php
declare(strict_types=1);

namespace App\Modules\Setting\Entity;

class Office extends AbstractSetting
{
    public string $name;
    public string $address;
    public string $longitude;
    public string $latitude;


}
