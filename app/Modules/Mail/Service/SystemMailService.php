<?php

namespace App\Modules\Mail\Service;

use App\Modules\Mail\Mailable\AbstractMailable;
use App\Modules\Mail\Entity\SystemMail;

class SystemMailService
{

    public function create(AbstractMailable $mailable, int $user_id): SystemMail
    {
        return SystemMail::register($mailable, $user_id);
    }

}
