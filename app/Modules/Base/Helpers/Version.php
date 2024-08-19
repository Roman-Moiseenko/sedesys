<?php
declare(strict_types=1);

namespace App\Modules\Base\Helpers;

use JetBrains\PhpStorm\ArrayShape;

class Version
{
    const version = '0.2.2';

    public static function updates(): array
    {
        return [
            '0.5' => [
                'Личный кабинет сотрудника',
                'Уровни доступа, фильтр меню по уровням',
                'Топ-меню - данные о сотруднике, иконка уведомления',
                '',
            ],
            '0.4. ... План на разработку' => [
                'Dashboard и Задачи',
                'Уведомление клиентов ч/з Whatsapp, vk, google-calendar',
                'Чат с клиентом - Мессенджеры VK, Avito и др., Jivo',
            ],
            '0.3. ... План на разработку' => [
                'Модуль Услуги, сущности Service',
                ' - доп.сущности: Цены, Категории, Атрибуты, Группы',
                'Специализация для Персонала',
                'Связывание Услуги с Персоналами и/или Специализацией',
                'Модуль Discount. Сущности Скидки',
                ' - доп.сущности: Акции, Купоны',
                'Модуль Web - отдельные страницы для Акций',
                'Модуль Web - отдельные страницы для Услуги, списка Цен',
            ],
            '0.2. Идет разработка ....' => [
                'Schema - добавлены настройки офиса',
                'Модуль Галерея - блок изображений по галереям, 2 способа использования:
                    а) с помощью ссылки на image, б) либо в редакторе кода через глобальную функцию photo()',
                'Модуль Шаблоны - создание своих шаблонов для виджетов и страниц и их редактирование поддерживает html, script, style, blade.php',
                'Модуль Уведомления (Notification) - Через CRM и Telegram для сотрудников и персонала, с подтверждением получения сообщения',
                'Настройка Сообщений через Телеграм - иконки, новые строки',
                'Создан Компонент Фильтр для таблиц по умолчанию, внедрен для всех текущих',
                'Отдельный модуль Почта содержит 3 сущности: Системная почта(v), Исходящие и Входящие (чз IMAP сервис)',
                'Стандартная авторизация клиента email или телефон (настраивается)',
                'Авторизация пользователей через Yandex, ...',
                '... разрабатывается ...',

                ' VK, Google, Telegram, Odnoklassniki и др.'
            ],
            '0.1. Базовая версия' => [
                'Сотрудники - раздел специалистов имеющих доступ к CRM.
                С полным доступом - Администратор, Руководитель, с ограниченным доступом - Сотрудники',
                'Персонал - Сотрудники, обслуживающие клиентов и имеющие карточку на сайте',
                'Клиенты - самостоятельно зарегистрированные пользователи. Возможность создание пользователя из CRM',
                'Страницы - самостоятельные информационные страницы',
                'Виджеты - блок данных, который можно отобразить на любой страницы, через шорт-код.',
                'Контакты - список для меню и подвала',
                'Базовые настройки - Организация, Офис и настройки сайта',
                'Подключена карта сайта xml',
                'Подключена schema'
            ],
        ];
    }
}
