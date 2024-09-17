<?php

return [
    'feedback' => [
        'sort' => 55,
        'icon' => 'ChatSquare',
        'title' => 'Обратная связь',
        'can' => '',
        'submenu' => [
            [
                'icon' => 'ChatLineSquare',
                'title' => 'Заявки',
                'route' => route('admin.feedback.feedback.dashboard', [], false),
            ],
            [
                'icon' => 'ScaleToOriginal',
                'title' => 'Шаблоны',
                'route' => route('admin.feedback.template.index', [], false),
            ],
            [
                'icon' => 'Wallet',
                'title' => 'Архив',
                'route' => route('admin.feedback.feedback.index', [], false),
            ],
        ],
    ],
];
