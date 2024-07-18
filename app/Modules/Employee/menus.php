<?php

return [
    'employees' => [
        'sort' => 2,
        'icon' => 'users',
        'title' => 'Персонал',
        'can' => 'staff',
        'submenu' => [
            'users' => [
                'icon' => 'printer',
                'title' => 'Список',
                'route' => route('admin.employee.employee.index'),
            ],
            'send' => [
                'icon' => 'printer',
                'title' => 'Оповещение',
                'route' => route('admin.employee.message.index'),
            ],
            'works' => [
                'icon' => 'printer',
                'title' => 'График работы',
                'route' => route('admin.employee.operating.index'),
            ],
        ],
    ],
];
