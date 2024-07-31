<?php
declare(strict_types=1);

namespace App\Modules\Setting\Entity;

class Organization extends AbstractSetting
{
    public string $name;
    public string $inn;
    public string $kpp;
    public string $ogrn;
    public string $bik;
    public string $bank;
    public string $bank_account;
    public string $account;
    public string $address;

}
