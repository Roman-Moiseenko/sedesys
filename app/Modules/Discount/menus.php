<?php

return [
    'discounts' => [
        'sort' => 60,
        'icon' => 'Coin',
        'title' => 'Скидки',
        'can' => '',
        'submenu' => [
            [
                'icon' => 'Present',
                'title' => 'Акции',
                'route' =>  route('admin.discount.promotion.index', [], false),
            ],
            [
                'icon' => 'Scissor',
                'title' => 'Купоны',
                'route' =>  route('admin.discount.coupon.index', [], false),
            ],
        ],
    ],
];
