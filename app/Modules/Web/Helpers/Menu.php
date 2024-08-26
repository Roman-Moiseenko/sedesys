<?php
declare(strict_types=1);

namespace App\Modules\Web\Helpers;

use App\Modules\Web\Repository\MenuRepository;
use JetBrains\PhpStorm\Deprecated;

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
        $menu = new MenuRepository();
        return [
            'page1' => [
                'icon' => '',
                'image' => '',
                'name' => 'Услуги',
                'submenu' => $menu->services(),
                'url' => '*****',
            ],
            'page1_1' => [
                'icon' => '',
                'image' => '',
                'name' => 'Категории',
                'submenu' => $menu->classifications(),
                'url' => '*****',
            ],
            'page1_2' => [
                'icon' => '',
                'image' => '',
                'name' => 'Категории и Услуги',
                'submenu' => $menu->classification_services(),
                'url' => '*****',
            ],
            'page2' => [
                'icon' => '',
                'image' => '',
                'name' => 'Специалисты',
                'route' => route('web.employee.index'),
                'url' => '*****',
            ],
            'page3' => [
                'icon' => '',
                'image' => '',
                'name' => 'Цены',
                'route' => route('web.home'),
                'url' => '*****',
            ],
            'page4' => [
                'icon' => '',
                'image' => '',
                'name' => 'Записаться',
                'route' => route('web.home'),
                'url' => '*****',
            ],
            'page5' => [
                'icon' => '',
                'image' => '',
                'name' => 'О нас',
                'url' => '*****',
                'submenu' => [
                    'page31' => [
                        'icon' => '',
                        'image' => '',
                        'name' => 'Контакты',
                        'url' => route('web.page.view', 'kontakty'),
                        //'route' => 'web.page.view',
                        //'item' => ,
                    ],
                    'page32' => [
                        'icon' => '',
                        'image' => '',
                        'name' => 'О Компании',
                        'url' => route('web.home'),
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

    #[Deprecated]
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
