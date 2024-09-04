<?php

return [
    'calendars' => [
        'sort' => 50,
        'icon' => 'Calendar',
        'title' => 'Календарь',

        'can' => '',
        'submenu' => [
            [
                'icon' => 'Watch',
                'title' => 'Календарь',
                'route' =>  route('admin.calendar.calendar.index', [], false),
            ],
            [
                'icon' => 'Magnet',
                'title' => 'Правила',
                'route' =>  route('admin.calendar.rule.index', [], false),
            ],
        ],
    ],
];
