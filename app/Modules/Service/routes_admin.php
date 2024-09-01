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
                Route::post('/{classification}/toggle', 'ClassificationController@toggle')->name('toggle');
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
        Route::group(
            [
                'prefix' => 'example',
                'as' => 'example.'
            ],
            function () {
                Route::post('/{example}/toggle', 'ExampleController@toggle')->name('toggle');
                Route::post('/{example}/add', 'ExampleController@add')->name('add');
                Route::post('/{example}/del', 'ExampleController@del')->name('del');
                Route::post('/{example}/set', 'ExampleController@set')->name('set');
                Route::post('/{example}/attach', 'ExampleController@attach')->name('attach');
                Route::post('/{example}/detach', 'ExampleController@detach')->name('detach');
            }
        );
        Route::group(
            [
                'prefix' => 'review',
                'as' => 'review.'
            ],
            function () {
                Route::post('/{review}/toggle', 'ReviewController@toggle')->name('toggle');
            }
        );
        Route::group(
            [
                'prefix' => 'extra',
                'as' => 'extra.'
            ],
            function () {
                Route::post('/{extra}/toggle', 'ExtraController@toggle')->name('toggle');
                Route::post('/{extra}/up', 'ExtraController@up')->name('up');
                Route::post('/{extra}/down', 'ExtraController@down')->name('down');
            }
        );
        Route::Resource('extra', 'ExtraController');

        Route::Resource('service', 'ServiceController');
        Route::Resource('classification', 'ClassificationController');
        Route::Resource('example', 'ExampleController');
        Route::Resource('review', 'ReviewController');
    }
);
