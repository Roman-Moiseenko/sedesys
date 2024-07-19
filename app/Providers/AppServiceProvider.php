<?php

namespace App\Providers;

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
        /*Validator::extend('cyrillic', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/[А-Яа-яЁё]/u', $value);
        });*/
    }
}
