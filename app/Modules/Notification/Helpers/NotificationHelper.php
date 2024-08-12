<?php
declare(strict_types=1);

namespace App\Modules\Notification\Helpers;

class NotificationHelper
{
    const EVENT_TEST = 1001;
    const EVENT_ERROR = 1002;
    const EVENT_CHIEF = 1003;


    const EVENTS = [
        self::EVENT_TEST => 'Тестовое событие',
        self::EVENT_ERROR => 'Ошибка',
        self::EVENT_CHIEF => 'От руководства',
    ];



}
