<?php

return [
    'users' => [
        'sort' => 30,
        'icon' => 'User',
        'title' => 'Клиенты',
        'route' => route('admin.user.user.index', [], false),
        'can' => 'staff',
    ],
];
