<?php

return [
    'settings' => [
        'sort' => 100,
        'icon' => 'setting',
        'title' => 'Настройки',
        'can' => '',
        'submenu' => [
            [
                'icon' => 'OfficeBuilding',
                'title' => 'Организация',
                'route' => route('admin.setting.organization', [], false),
            ],
            [
                'icon' => 'Location',
                'title' => 'Офис',
                'route' => route('admin.setting.office', [], false),
            ],
            [
                'icon' => 'Monitor',
                'title' => 'Верстка',
                'route' => route('admin.setting.web', [], false),
            ],
            [
                'icon' => 'MessageBox',
                'title' => 'Уведомления',
                'route' => route('admin.setting.notification', [], false),
            ],
        ],
    ],
];
