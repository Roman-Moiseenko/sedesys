<?php
declare(strict_types=1);

namespace App\Modules\Web\Helpers;

use App\Modules\Web\Repository\MenuRepository;
use JetBrains\PhpStorm\Deprecated;

class Menu
{
    /**
     * Определ
     * @return array
     */
    public static function menuTop(): array
    {
        $menu = new MenuRepository();
        //TODO Временное решение
        // В дальнейшем брать из базы структуру
        return [
            'page1' => [
                'icon' => '',
                'name' => 'Услуги',
                'url' => route('web.classification.index'),
                'submenu' => $menu->classification_services(),
            ],
            'page2' => [
                'icon' => '',
                'name' => 'Наша команда',
                'url' => route('web.specialization.index'),
                'submenu' => $menu->specializations(),
            ],

            'page3' => [
                'icon' => '',
                'name' => 'Цены',
                'url' => route('web.home'),
            ],
            'page4' => [
                'icon' => '',
                'name' => 'Записаться',
                'url' => route('web.home'),
            ],
            'page5' => $menu->page(3),
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
