<?php

return [
    'admins' => [
        'sort' => 1,
        'icon' => 'Management',
        'title' => 'Сотрудники',
        'route' => route('admin.staff.index', [], false),
        'can' => 'staff',
    ],
];
