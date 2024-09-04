<?php

return [
    'notifications' => [
        'sort' => 70,
        'icon' => 'Bell',
        'title' => 'Уведомления',
        'route' => route('admin.notification.notification.index', [], false),
        'can' => '',
    ],
];
