<?php
declare(strict_types=1);

namespace App\Modules\Calendar\Entity;

class Regularity
{
    const EVERYDAY = 9000;
    const WEEK_MON = 9010;
    const WEEK_TUE = 9011;
    const WEEK_WED = 9012;
    const WEEK_THU = 9013;
    const WEEK_FRI = 9014;
    const WEEK_SAT = 9015;
    const WEEK_SUN = 9016;
    const WEEK_WEEKDAY = 9017;
    const WEEK_PART_TIME = 9018;
    const WEEK_WEEKENDS = 9019;
    const X1_FIRST = 9020;
    const X1_SECOND = 9021;
    const X2_FIRST = 9030;
    const X2_SECOND = 9031;

    const REPEAT_DAYS = [
        self::EVERYDAY => 'Ежедневно',
        self::WEEK_MON => 'Понедельник',
        self::WEEK_TUE => 'Вторник',
        self::WEEK_WED => 'Четверг',
        self::WEEK_THU => 'Среда',
        self::WEEK_FRI => 'Пятница',
        self::WEEK_SAT => 'Суббота',
        self::WEEK_SUN => 'Воскресенье',
        self::WEEK_WEEKDAY => 'Рабочие дни',
        self::WEEK_PART_TIME => 'С Пн по Чт',
        self::WEEK_WEEKENDS => 'Выходные',
        self::X1_FIRST => 'День ч/з день. 1',
        self::X1_SECOND => 'День ч/з день. 2',
        self::X2_FIRST => 'Два ч/з два. 1',
        self::X2_SECOND => 'Два ч/з два. 2',
    ];

    const TYPES = [
        'everyday' => '0',
        'week' => [
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
            'Sat',
            'Sun',
            'weekday', //с Пн по Пт
            'part-time', //с Пн по Чт
            'weekends',
        ],
        '1x1' => [
            'first',
            'second',
        ],
        '2x2' => [
            'first',
            'second',
        ],
    ];
}
