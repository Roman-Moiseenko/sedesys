<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'service',
        'as' => 'service.'
    ],
    function () {
        Route::group(
            [
                'prefix' => 'classification',
                'as' => 'classification.'
            ],
            function () {
                Route::post('/{classification}/up', 'ClassificationController@up')->name('up');
                Route::post('/{classification}/down', 'ClassificationController@down')->name('down');
            }
        );

        Route::group(
            [
                'prefix' => 'service',
                'as' => 'service.'
            ],
            function () {
                Route::post('/{service}/toggle', 'ServiceController@toggle')->name('toggle');
                Route::post('/{service}/add', 'ServiceController@add')->name('add');
                Route::post('/{service}/del', 'ServiceController@del')->name('del');
                Route::post('/{service}/set', 'ServiceController@set')->name('set');
                Route::post('/{service}/attach', 'ServiceController@attach')->name('attach');
                Route::post('/{service}/detach', 'ServiceController@detach')->name('detach');
            }
        );

        Route::Resource('service', 'ServiceController');
        Route::Resource('classification', 'ClassificationController');

    }
);
