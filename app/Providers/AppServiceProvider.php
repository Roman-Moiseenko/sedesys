<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            $this->app['request']->server->set('HTTPS','on');
            URL::forceScheme('https');
        }
        Carbon::setLocale(config('app.locale'));

        /*Validator::extend('cyrillic', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/[А-Яа-яЁё]/u', $value);
        });*/
    }
}
