<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'page',
    'as' => 'page.'
],
    function () {
        Route::post('/page/{page}/toggle', 'PageController@toggle')->name('page.toggle');
        Route::post('/widget/{widget}/toggle', 'WidgetController@toggle')->name('widget.toggle');
        Route::post('/contact/{contact}/toggle', 'ContactController@toggle')->name('contact.toggle');
        Route::post('/contact/{contact}/up', 'ContactController@up')->name('contact.up');
        Route::post('/contact/{contact}/down', 'ContactController@down')->name('contact.down');

        Route::Resource('page', 'PageController');
        Route::Resource('widget', 'WidgetController');
        Route::Resource('contact', 'ContactController');
    }
);

