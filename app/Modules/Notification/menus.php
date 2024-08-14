<?php

return [
    'notifications' => [
        'sort' => 40,
        'icon' => 'Bell',
        'title' => 'Уведомления',
        'route' => route('admin.notification.notification.index', [], false),
        'can' => '',
    ],
];
