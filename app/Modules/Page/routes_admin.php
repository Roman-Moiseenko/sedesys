<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'page',
    'as' => 'page.'
],
    function () {
        Route::post('/page/{page}/toggle', 'PageController@toggle')->name('page.toggle');
        Route::post('/widget/{widget}/toggle', 'WidgetController@toggle')->name('widget.toggle');
        Route::Resource('page', 'PageController');
        Route::Resource('widget', 'WidgetController');
    }
);

