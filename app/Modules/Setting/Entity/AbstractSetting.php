<?php
declare(strict_types=1);

namespace App\Modules\Setting\Entity;

abstract class AbstractSetting
{

    public function __construct(array $data)
    {
        foreach ($data as $field => $value) {
            if (isset($this->$field)) {
                if (is_numeric($this->$field)) $this->$field = $value ?? 0;
                if (is_bool($this->$field)) $this->$field = $value ?? false;
                if (is_string($this->$field)) $this->$field = $value ?? '';
                if (is_array($this->$field)) $this->$field = $value ?? [];
            }
        }
    }
}
