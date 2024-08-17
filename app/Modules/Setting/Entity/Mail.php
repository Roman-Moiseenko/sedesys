<?php
declare(strict_types=1);

namespace App\Modules\Setting\Entity;

class Mail extends AbstractSetting
{
    public string $inbox_domain = '';
    /**
     * В версии до 1 используется только 1 почтовый ящик, далее будет массив
     */
    public string $inbox_name ='';
    public string $inbox_password ='';
    public bool $inbox_delete = false;

    /**
     * В версии > 1 добавить настройки исходящей почты (с записью в .env)
     */

}
