<?php

return [
    'mails' => [
        'sort' => 80,
        'icon' => 'MessageBox',
        'title' => 'Почта',
        'can' => '',
        'submenu' => [
            [
                'icon' => 'Edit',
                'title' => 'Написать',
                'route' => route('admin.mail.outbox.create', [], false),
            ],
            [
                'icon' => 'Position',
                'title' => 'Исходящие',
                'route' => route('admin.mail.outbox.index', [], false),
            ],
            [
                'icon' => 'Message',
                'title' => 'Входящие',
                'route' => route('admin.mail.inbox.index', [], false),
            ],
            [
                'icon' => 'Setting',
                'title' => 'Системная',
                'route' => route('admin.mail.system.index', [], false),
            ],
        ],
    ],
];
