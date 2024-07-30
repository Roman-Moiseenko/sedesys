<?php

return [
    'pages' => [
        'sort' => 40,
        'icon' => 'DocumentCopy',
        'title' => 'Страницы',
        'can' => '',
        'submenu' => [
            [
                'icon' => 'Document',
                'title' => 'Страницы',
                'route' => route('admin.page.page.index', [], false),
            ],
            [
                'icon' => 'Postcard',
                'title' => 'Виджеты',
                'route' => route('admin.page.widget.index', [], false),
            ],
        ],

    ],
];
