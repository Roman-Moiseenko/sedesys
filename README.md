<p align="center"><a href="https://sedesys.ru" target="_blank">
<img src="" width="400" alt="Sedesys Log">
</a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About SeDeSys

Описание проекта,
его плюсы и достоинства

- [Ссылка на документацию](https://laravel.com/docs/routing).


## Первоначальная Настройка

Для получения почты, хостинг должен поддерживать imap

Подключение TinyMCE [добавить ссылку](https://laravel.com/docs)

Для Telegram создать чат-бот [добавить ссылку на инструкцию](https://laravel.com/docs)

Подключение через сервисы Oauth2
- Яндекс - [Yandex Oauth](https://oauth.yandex.ru/client/new/id/)
- Телеграм - [Настройка бота](https://core.telegram.org/widgets/login)
- Гугл - [Настройка приложения](https://console.developers.google.com/apis) [Инструкция](https://www.positronx.io/laravel-9-socialite-login-with-google-example-tutorial/) 
- ВКонтакте - [Настройка приложения](https://id.vk.com/about/business/go/create-account)


## Laravel Sponsors

Где реализовано, 
- **[Ссылка на сайт](https://vehikl.com/)**
- **[Ссылка на сайт](https://tighten.co)**
- **[Ссылка на сайт](https://kirschbaumdevelopment.com)**
- **[Ссылка на сайт](https://64robots.com)**
- 
### Наши партнеры и спонсоры

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**


## События
###Модуль Calendar
- Событие "Запись на услугу поменяла статус" - RecordHasChangeStatus слушатели:
- * RecordEmployee - Уведомление Персоналу на **telegram**, с подтверждением или отказом о записи
- * RecordStaff - Уведомление Специалисту(по уровню доступа) в **CRM** 
- * RecordUser - Уведомление клиенту в ВК, GoogleCalendar, WhatsApp, Telegram и др.
    
###Модуль Discount
- Событие "акция была запущена" - PromotionHasStart *(слушатель не назначен)*
- Событие "акция была остановлена" - PromotionHasFinish *(слушатель не назначен)*

###Модуль Notification
- Событие "Получено обратное сообщение от телеграм" - TelegramHasReceived, слушатели:
- * NotificationService::class, //Подтверждение уведомления 
- * CalendarService::class, //Подтверждение записи
- * ... назначить любых слушателей, и сравнивать тип возвращаемой операции TelegramParams::OPERATION_xxx 

##Публикуемые классы
###Определение

###Общие свойства

###Дополнительные интерфейсы

###Наследники



##Шаблоны

##Планировщик и Команды (Cron)
Планировщик:
- Автозапуск и остановка акций по времени *(Ежедневно)* promotion:auto - *PromotionCommand*
- Получение почты *(Ежечасно)* inbox:load  - *InboxCommand*

Команды:
- Создание Администратора сайта: **admin:create {name}**
- Смена пароля Администратора сайта: **admin:password {--name= : "Логин для смены пароля"}**
- Получить id сотрудников, подключивших чат-бот: **telegram:bot**
- Подключение прослушивания чат-бота Телеграм: **telegram:set-webhook**
- Отключение прослушивания чат-бота Телеграм: **telegram:del-webhook**
- Проверка прослушивания чат-бота Телеграм: **telegram:get-webhook**

##Разработанные модули


## License

Лицензия на использование продукта приобретается вместе с услугой разработки сайта и включена в стоимость работ.
