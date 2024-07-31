<?php
declare(strict_types=1);

namespace App\Modules\Setting\Entity;

abstract class AbstractSetting
{
    public function __construct(array $data)
    {
        foreach ($data as $field => $value) {
            $this->$field = $value;
        }
    }
}
