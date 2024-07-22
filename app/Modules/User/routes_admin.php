<?php


use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'user',
    'as' => 'user.',
], function() {
    Route::resource('user', 'UserController');
    Route::post('/user/{user}/verify', 'UserController@verify')->name('user.verify');
});
