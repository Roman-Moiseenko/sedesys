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

        Route::get('/outbox/attachment', 'OutboxController@attachment')->name('outbox.attachment');
        Route::post('/outbox/repeat/{outbox}', 'OutboxController@repeat')->name('outbox.repeat');
        Route::post('/outbox/send/{outbox}', 'OutboxController@send')->name('outbox.send');
        Route::post('/outbox/delete-attachment/{outbox}', 'OutboxController@delete_attachment')->name('outbox.delete-attachment');
        Route::get('/inbox/attachment', 'InboxController@attachment')->name('inbox.attachment');
        Route::get('/inbox/load', 'InboxController@load')->name('inbox.load');


        Route::Resource('inbox', 'InboxController')->only(['index', 'show', 'destroy']);
        Route::Resource('outbox', 'OutboxController');

    }
);
