<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'page',
    'as' => 'page.'
],
    function () {
        Route::post('/page/{page}/toggle', 'PageController@toggle')->name('page.toggle');
        Route::post('/widget/{widget}/toggle', 'WidgetController@toggle')->name('widget.toggle');

        Route::group([
            'prefix' => 'contact',
            'as' => 'contact.',
        ], function() {
            Route::post('/{contact}/toggle', 'ContactController@toggle')->name('toggle');
            Route::post('/{contact}/up', 'ContactController@up')->name('up');
            Route::post('/{contact}/down', 'ContactController@down')->name('down');
        });
        Route::group([
            'prefix' => 'gallery',
            'as' => 'gallery.',
        ], function() {
            Route::post('/{gallery}/add', 'GalleryController@add')->name('add');
            Route::post('/{gallery}/del', 'GalleryController@del')->name('del');
            Route::post('/{gallery}/set', 'GalleryController@set')->name('set');
            Route::post('/get-tree', 'GalleryController@get_tree')->name('get-tree');
            Route::post('/get-photo', 'GalleryController@get_photo')->name('get-photo');

        });
        Route::group([
            'prefix' => 'template',
            'as' => 'template.',
        ], function() {
            Route::get('/', 'TemplateController@index')->name('index');
            Route::get('/{type}/{template}', 'TemplateController@show')->name('show');
            Route::post('/', 'TemplateController@store')->name('store');
            Route::put('/', 'TemplateController@update')->name('update');
            Route::delete('/{type}/{template}', 'TemplateController@destroy')->name('destroy');
        });


        Route::Resource('page', 'PageController');
        Route::Resource('widget', 'WidgetController');
        Route::Resource('contact', 'ContactController');
        Route::Resource('gallery', 'GalleryController');
       // Route::Resource('template', 'TemplateController');
    }
);

