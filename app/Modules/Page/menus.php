<?php

return [
    'pages' => [
        'sort' => 40,
        'icon' => 'office',
        'title' => 'Страницы',
        'can' => '',
        'submenu' => [
            [
                'icon' => 'office',
                'title' => 'Страницы',
                'route' => route('admin.page.page.index', [], false),
            ],
            [
                'icon' => 'office',
                'title' => 'Виджеты',
                'route' => route('admin.page.widget.index', [], false),
            ],
        ],

    ],
];
