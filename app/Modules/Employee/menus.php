<?php

return [
    'employees' => [
        'sort' => 20,
        'icon' => 'Service',
        'title' => 'Персонал',
        'can' => 'staff',
        'submenu' => [
            'users' => [
                'icon' => 'List',
                'title' => 'Список',
                'route' => route('admin.employee.employee.index', [], false),
            ],
            'specialization' => [
                'icon' => 'Connection',
                'title' => 'Специализация',
                'route' => route('admin.employee.specialization.index', [], false),
            ],
        ],
    ],
];
