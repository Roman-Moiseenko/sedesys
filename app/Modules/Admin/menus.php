<?php

return [
    'admins' => [
        'sort' => 1,
        'icon' => 'office',
        'title' => 'Сотрудники',
        'route' => route('admin.staff.index', [], false),
        'can' => 'staff',
    ],
];
