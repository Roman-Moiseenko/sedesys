<?php

namespace App\Providers;

use App\Modules\Calendar\Events\RecordHasChangeStatus;
use App\Modules\Calendar\Notification\RecordEmployee;
use App\Modules\Calendar\Notification\RecordStaff;
use App\Modules\Calendar\Notification\RecordUser;
use App\Modules\Calendar\Service\CalendarService;
use App\Modules\Discount\Events\PromotionHasFinish;
use App\Modules\Discount\Events\PromotionHasStart;
use App\Modules\Feedback\Events\FeedbackHasSend;
use App\Modules\Feedback\Notification\FeedbackStaff;
use App\Modules\Feedback\Service\FeedbackService;
use App\Modules\Notification\Events\TelegramHasReceived;
use App\Modules\Notification\Service\NotificationService;
use App\Modules\Order\Events\OrderHasAwaiting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Google\GoogleExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Telegram\TelegramExtendSocialite;
use SocialiteProviders\VKontakte\VKontakteExtendSocialite;
use SocialiteProviders\Yandex\YandexExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TelegramHasReceived::class => [
            NotificationService::class, //Подтверждение уведомления
            CalendarService::class, //Подтверждение записи
            FeedbackService::class, //Взятие в работу заявки
            /**
             * Добавляем классы, которые обрабатывают подтверждения из Телеграм.
             */

        ],

        //Модуль Календарь
        RecordHasChangeStatus::class => [
            RecordEmployee::class,
            RecordStaff::class,
            RecordUser::class
        ],

        //Модуль Скидки
        PromotionHasStart::class => [
            /**
             * При необходимости добавить уведомления подписчикам и/или сотрудникам.
             */
        ],
        PromotionHasFinish::class => [
            /**
             * При необходимости добавить уведомления подписчикам и/или сотрудникам.
             */
        ],
        //Модуль Feedback
        FeedbackHasSend::class => [
            FeedbackStaff::class, //Сотрудники по работе с Обратной связью получают сообщения
        ],

        //Модуль Order
        OrderHasAwaiting::class => [
            /**
             * При необходимости добавить уведомления подписчикам и/или сотрудникам.
             * Высылка счета
             */
        ],

        //Аутентификация сторонними сервисами
        SocialiteWasCalled::class => [
            YandexExtendSocialite::class.'@handle',
            TelegramExtendSocialite::class.'@handle',
            GoogleExtendSocialite::class.'@handle',
            VKontakteExtendSocialite::class.'@handle',
            /**
             * Добавить при желании клиента
             */
        ],

        //
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
