<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'Auth',
    ],
    function () {
        Route::post('/login', 'LoginController@login')->name('login');
        Route::get('/login', function () {
            abort(404);
        });
        Route::post('/login-register', 'LoginController@login_registration')->name('login-register');
        Route::any('/logout', 'LoginController@logout')->name('logout');


        Route::get('/register/verify', 'RegisterController@verify')->name('register.verify');
        Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('/register', 'RegisterController@register');


        //Сброс и восстановление пароля по email
        Route::group([
            'prefix' => 'password',
            'as' => 'password.',
        ], function() {
            Route::get('/reset', 'ForgotPasswordController@showLinkRequestForm')->name('request');
            Route::post('/reset', 'ResetPasswordController@reset')->name('update');
            Route::get('/reset/{token}', 'ResetPasswordController@showResetForm')->name('reset');
            Route::get('/confirm', 'ConfirmPasswordController@showConfirmForm')->name('confirm');
            Route::post('/confirm', 'ConfirmPasswordController@confirm');
            Route::post('/email', 'ForgotPasswordController@sendResetLinkEmail')->name('email');
            //Новый пароль по СМС
            Route::post('/phone', 'LoginController@phone')->name('phone');
        });

    }
);

Route::group([
    'prefix' => 'oauth',
    'namespace' => 'OAuth',
    'as' => 'oauth.',
], function () {

    Route::get('/yandex/callback', 'YandexController@callback')->name('yandex.callback');
    Route::get('/yandex', 'YandexController@oauth')->name('yandex');

    Route::get('/telegram/callback', 'TelegramController@callback')->name('telegram.callback');
    Route::get('/telegram', 'TelegramController@oauth')->name('telegram');

    Route::get('/google/callback', 'GoogleController@callback')->name('google.callback');
    Route::get('/google', 'GoogleController@oauth')->name('google');

    Route::get('/vk/callback', 'VKController@callback')->name('vk.callback');
    Route::get('/vk', 'VKController@oauth')->name('vk');

    /**
     * Другие соц.сети
     */
});
