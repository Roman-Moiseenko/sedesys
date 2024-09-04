<?php

use Illuminate\Support\Facades\Route;
Route::group(
    [
        'prefix' => 'calendar',
        'as' => 'calendar.'
    ],
    function() {

        Route::post('/rule/{rule}/toggle', 'RuleController@toggle')->name('rule.toggle');
        Route::group(
            [
                'prefix' => 'calendar',
                'as' => 'calendar.'
            ],
            function() {

                Route::any('/create', 'CalendarController@create')->name('create');
                Route::get('/{calendar}', 'CalendarController@show')->name('show');
                Route::delete('/destroy/{calendar}', 'CalendarController@destroy')->name('destroy');
                //Route::post('/store', 'CalendarController@store')->name('store');
                Route::get('/', 'CalendarController@index')->name('index');
            }
        );

        //Route::Resource('calendar', 'CalendarController');
        Route::Resource('rule', 'RuleController');
    }
);
