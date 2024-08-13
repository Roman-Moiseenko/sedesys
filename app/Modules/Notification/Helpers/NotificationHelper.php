<?php
declare(strict_types=1);

namespace App\Modules\Notification\Helpers;

class NotificationHelper
{


    const EVENT_TEST = 1001;
    const EVENT_ERROR = 1002;
    const EVENT_CHIEF = 1003;
    const EVENT_INFO = 1004;

    const EVENT_NEW_ORDER = 1010;
    const EVENT_ORDER_RECEIVED = 1011;

    const EVENTS = [
        self::EVENT_TEST => 'Тестовое событие',
        self::EVENT_ERROR => 'Ошибка',
        self::EVENT_CHIEF => 'От руководства',
        self::EVENT_INFO => 'Информирование',
        self::EVENT_NEW_ORDER => 'Новый заказ',
        self::EVENT_ORDER_RECEIVED => 'Заказ получен',
    ];

    /**
     * Смайлики для обозначения Событий
     * https://apps.timwhitlock.info/emoji/tables/unicode
     */
    const EMOJI = [
        self::EVENT_TEST => "\xE2\x9C\x94", //✔
        self::EVENT_ERROR => "\xE2\x9D\x8C",
        self::EVENT_CHIEF => "\xF0\x9F\x93\xA3",
        self::EVENT_INFO => "\xE2\x84\xB9",
        self::EVENT_NEW_ORDER => "\xF0\x9F\x93\x8B",
        self::EVENT_ORDER_RECEIVED => "\xE2\x9C\x85", //✅

    ];


}
