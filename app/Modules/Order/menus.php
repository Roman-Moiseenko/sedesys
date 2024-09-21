<?php

return [
    'orders' => [
        'sort' => 35,
        'icon' => 'Sell',
        'title' => 'Продажи',
        'can' => '',
        'submenu' => [
            [
                'icon' => 'List',
                'title' => 'Заказы',
                'route' => route('admin.order.order.index', [], false),
            ],
            [
                'icon' => 'WalletFilled',
                'title' => 'Платежи',
                'route' => route('admin.order.payment.index', [], false),
            ],
        ],
    ],
];
