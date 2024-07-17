<?php

use Illuminate\Support\Facades\Route;


Route::group([
    'prefix'=> 'admin',
    'namespace' => 'App\Modules\Admin\Controllers\Auth',
    'as' => 'admin.',
], function() {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login');
});

Route::get('/', 'App\Modules\Web\Controllers\WebController@index')->name('web.home');
