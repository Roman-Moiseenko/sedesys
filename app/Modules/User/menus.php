<?php

return [
    'users' => [
        'sort' => 30,
        'icon' => 'users',
        'title' => 'Клиенты',
        'route' => route('admin.user.user.index', [], false),
        'can' => 'staff',
    ],
];
