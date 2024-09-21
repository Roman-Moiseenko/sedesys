<?php


use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'user',
    'as' => 'user.',
], function() {
    Route::resource('user', 'UserController');
    Route::post('/user/{user}/verify', 'UserController@verify')->name('user.verify');
    Route::post('/user/find_phone', 'UserController@find_phone')->name('find_phone');
    Route::post('/user/find', 'UserController@find')->name('user.find');
    Route::post('/user/{user}/set', 'UserController@set')->name('user.set');
});
