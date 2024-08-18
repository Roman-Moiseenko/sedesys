<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'Auth',
    ],
    function () {
        //Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login')->name('login');
    }
);

Route::group([
    'prefix' => 'oath',
    'namespace' => 'OAuth',
    'as' => 'oath.',
], function () {
    Route::get('/yandex', 'YandexController@oauth')->name('yandex.oauth');
    Route::get('/yandex', 'YandexController@callback')->name('yandex.callback');
    /**
     * Другие соц.сети
     */
});
