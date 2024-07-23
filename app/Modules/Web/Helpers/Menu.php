<?php
declare(strict_types=1);

namespace App\Modules\Web\Helpers;

class Menu
{
//TODO Временное решение
// Заменить на Entity или Modules

    public static function menuTop(): array
    {
        return [
            [
                'icon' => '',
                'image' => '',
                'name' => 'Страница 1',
                'url' => '/',
            ],
            [
                'icon' => '',
                'image' => '',
                'name' => 'Страница 2',
                'url' => '/',
            ],
            [
                'icon' => '',
                'image' => '',
                'name' => 'Страница 3',

                'url' => '/',
                'submenu' => [
                    [
                        'icon' => '',
                        'image' => '',
                        'name' => 'Страница 3.1',
                        'url' => '/',
                    ],
                    [
                        'icon' => '',
                        'image' => '',
                        'name' => 'Страница 3.2',
                        'url' => '/',
                    ],
                ]
            ],
        ];
    }

    public static function menuMobile(bool $login = false): array
    {
        $menu = [
            [
                'icon' => 'fa-light fa-house',
                'name' => 'Главная',
                'url' => '/',
            ],
            [
                'icon' => 'fa-light fa-folder-magnifying-glass',
                'name' => 'Каталог',
                'url' => '/',
            ],
            [
                'icon' => 'fa-light fa-cart-shopping',
                'name' => 'Корзина',
                'url' => '/',
            ],
            [
                'icon' => 'fa-light fa-lightbulb',
                'name' => 'Текст',
                'url' => '/',
            ],
        ];

        if ($login) {
            $menu[] = [
                'icon' => 'fa-light fa-user-vneck',
                'name' => 'Кабинет',
                'url' => '/',
            ];
        } else {
            $menu[] = [
                'icon' => 'fa-light fa-user-vneck',
                'name' => 'Войти',
                'url' => '#',
            ];
        }
        return $menu;
    }

    public static function menuContact(): array
    {
        return [
            [
                'icon' => 'fa-light fa-user-vneck',
                'image' => '',
                'class' => '',
                'name' => 'VK',
                'color' => '',
                'url' => '',
                ],

        ];
    }

    //TODO Список от 1 до 3 массивов
    public static function menuFooter(): array
    {
        return [
            ['icon' => '',
                'image' => '',
                'name' => '',
                'class' => '',
                'url' => '',],
        ];
    }
}
