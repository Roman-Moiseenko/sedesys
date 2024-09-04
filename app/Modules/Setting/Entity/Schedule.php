<?php
declare(strict_types=1);

namespace App\Modules\Setting\Entity;

class Schedule extends AbstractSetting
{
    public string $begin_x_date = '2024-01-01';
    public string $begin_work = '08:00';
    public string $end_work = '18:00';
    public array $holiday = [];
}
