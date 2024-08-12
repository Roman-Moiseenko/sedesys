<?php

return [
    'notifications' => [
        'sort' => 40,
        'icon' => 'MessageBox',
        'title' => 'Обратная связь',
        'can' => '',
        'submenu' => [
            [
                'icon' => 'Notification',
                'title' => 'Уведомления',
                'route' => route('admin.notification.notification.index', [], false),
            ],
            [
                'icon' => 'ChatDotRound',
                'title' => 'Чат с клиентами',
                'route' => route('admin.page.page.index', [], false),
            ],
            [
                'icon' => 'Message',
                'title' => 'Почта',
                'route' => route('admin.page.page.index', [], false),
            ],
        ],
    ],
];
