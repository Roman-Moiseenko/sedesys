<?php

return [
    'employees' => [
        'icon' => 'users',
        'title' => 'Персонал',
        //'route_name' => 'admin.employee.index',
        'can' => 'staff',
        'submenu' => [
            'users' => [
                'icon' => 'printer',
                'title' => 'Список',
                'route_name' => 'admin.employee.index',
            ],
            'send' => [
                'icon' => 'printer',
                'title' => 'Оповещение',
                'route_name' => 'admin.employee.index',
            ],
            'works' => [
                'icon' => 'printer',
                'title' => 'График работы',
                'route_name' => 'admin.employee.index',
            ],
        ],
    ],
];
