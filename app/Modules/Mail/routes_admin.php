<?php

use Illuminate\Support\Facades\Route;


Route::group(
    [
        'prefix' => 'mail',
        'as' => 'mail.'
    ],
    function() {

        Route::Resource('system', 'SystemMailController')->only(['index', 'show']);
        Route::post('/system/repeat', 'SystemMailController@repeat')->name('system.repeat');
        Route::Resource('inbox', 'InboxController')->only(['index', 'show']);
        Route::Resource('outbox', 'OutboxController');
    }
);
