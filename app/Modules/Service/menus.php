<?php

return [
    'services' => [
        'sort' => 35,
        'icon' => 'Suitcase',
        'title' => 'Услуги',
        'can' => '',
        'submenu' => [
            'list' => [
                'icon' => 'SuitcaseLine',
                'title' => 'Услуги',
                'route' => route('admin.service.service.index', [], false),
            ],
            'classification' => [
                'icon' => 'Memo',
                'title' => 'Классификация',
                'route' => route('admin.service.classification.index', [], false),
            ],
            'example' => [
                'icon' => 'Help',
                'title' => 'Примеры работ',
                'route' => route('admin.service.example.index', [], false),
            ],
            'review' => [
                'icon' => 'ChatLineSquare',
                'title' => 'Отзывы',
                'route' => route('admin.service.review.index', [], false),
            ],
        ],
    ],
];
