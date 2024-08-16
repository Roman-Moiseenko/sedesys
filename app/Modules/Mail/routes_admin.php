<?php

use Illuminate\Support\Facades\Route;


Route::group(
    [
        'prefix' => 'mail',
        'as' => 'mail.'
    ],
    function() {
        Route::get('/system/attachment', 'SystemMailController@attachment')->name('system.attachment');

        Route::Resource('system', 'SystemMailController')->only(['index', 'show']);
        Route::post('/system/repeat/{system}', 'SystemMailController@repeat')->name('system.repeat');


        Route::post('/outbox/repeat/{outbox}', 'OutboxController@repeat')->name('outbox.repeat');
        Route::post('/outbox/send/{outbox}', 'OutboxController@send')->name('outbox.send');
        Route::post('/outbox/delete-attachment/{outbox}', 'OutboxController@delete_attachment')->name('outbox.delete-attachment');


        Route::Resource('inbox', 'InboxController')->only(['index', 'show']);
        Route::Resource('outbox', 'OutboxController');

    }
);
