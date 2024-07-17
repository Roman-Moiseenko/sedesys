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
