<?php
declare(strict_types=1);

namespace App\Modules\Web\Helpers;

class Menu
{
//TODO Временное решение
// Заменить на Entity или Modules

    /**
     * Определ
     * @return array
     */
    public static function menuTop(): array
    {
        return [
            'page1' => [
                'icon' => '',
                'image' => '',
                'name' => 'Услуги',
                'route' => 'web.home',
            ],
            'page2' => [
                'icon' => '',
                'image' => '',
                'name' => 'Мастера',
                'route' => 'web.home',
            ],
            'page3' => [
                'icon' => '',
                'image' => '',
                'name' => 'Цены',
                'route' => 'web.home',
            ],
            'page4' => [
                'icon' => '',
                'image' => '',
                'name' => 'Записаться',
                'route' => 'web.home',
            ],
            'page5' => [
                'icon' => '',
                'image' => '',
                'name' => 'О нас',

                //'route' => 'web.home',
                'submenu' => [
                    'page31' => [
                        'icon' => '',
                        'image' => '',
                        'name' => 'Контакты',
                        'route' => 'web.page.view',
                        'item' => 'kontakty',
                    ],
                    'page32' => [
                        'icon' => '',
                        'image' => '',
                        'name' => 'О Компании',
                        'route' => 'web.home',
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
                'icon' => 'fa-brands fa-vk',
                'image' => '',
                'class' => '',
                'name' => 'VK',
                'color' => '#333333',
                'url' => '',
            ],
            [
                'icon' => 'fa-brands fa-telegram',
                'image' => '',
                'class' => '',
                'name' => 'Telegram',
                'color' => '#333333',
                'url' => '',
            ],
        ];
    }

    //TODO Список от 1 до 3 массивов
    public static function menuFooter(): array
    {
        return [
            [
                'title' => 'Колонка 1',
                'items' => [
                    ['icon' => '',
                        'image' => '',
                        'name' => 'Страница 1',
                        'class' => '',
                        'route' => 'web.home',
                    ],
                ],
            ],
            [
                'title' => 'Колонка 2',
                'items' => [
                    ['icon' => '',
                        'image' => '',
                        'name' => 'Страница 2',
                        'class' => '',
                        'route' => 'web.home',
                    ],
                ],
            ],
            [
                'title' => 'Колонка 3',
                'items' => [
                    ['icon' => '',
                        'image' => '',
                        'name' => 'Страница 3',
                        'class' => '',
                        'route' => 'web.home',
                    ],
                ],
            ],


        ];
    }
}
