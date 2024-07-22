<?php

return [
    'employees' => [
        'sort' => 20,
        'icon' => 'users',
        'title' => 'Персонал',
        'can' => 'staff',
        'submenu' => [
            'users' => [
                'icon' => 'printer',
                'title' => 'Список',
                'route' => route('admin.employee.employee.index', [], false),
            ],
            'specialization' => [
                'icon' => 'printer',
                'title' => 'Специализация',
                'route' => '', //route('admin.employee.specialization.index', [], false),
            ],
        ],
    ],
];
