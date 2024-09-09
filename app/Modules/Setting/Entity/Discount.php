<?php
declare(strict_types=1);

namespace App\Modules\Setting\Entity;

class Discount extends AbstractSetting
{
    public int $coupon_length = 6; //Длина кода купона в символах
    public bool $coupon_full = false; //Использовать строчные символы в купоне - true, только заглавные и цифры - false



}
