<?php

namespace App\Providers;

use App\Modules\Notification\Events\TelegramHasReceived;
use App\Modules\Notification\Service\NotificationService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Telegram\TelegramExtendSocialite;
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
            NotificationService::class,
            //TODO Добавляем классы которые обрабатывают подтверждения из Телеграм

        ],

        SocialiteWasCalled::class => [
            // ... other providers

            YandexExtendSocialite::class.'@handle',
            TelegramExtendSocialite::class.'@handle',
        ],
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
