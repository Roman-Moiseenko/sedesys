<?php

use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'notification',
    'as' => 'notification.',
],
function(){
    Route::post('/notification/read/{notification}', 'NotificationController@read')->name('notification.read');
    Route::post('/telegram/chat-id', 'TelegramController@chat_id')->name('telegram.chat-id');
    Route::any('telegram/web-hook', 'TelegramController@web_hook')->name('telegram.web-hook');
    //Route::get('/notification/', 'NotificationController@index')->name('notification.index');

    Route::Resource('notification', 'NotificationController')->only(['index', 'create', 'store']);
});

