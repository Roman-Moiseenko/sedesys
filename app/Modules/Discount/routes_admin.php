<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'discount',
    'as' => 'discount.',
], function() {
    Route::group([
        'prefix' => 'promotion',
        'as' => 'promotion.',
    ], function() {
        Route::post('/{promotion}/toggle', 'PromotionController@toggle')->name('toggle');
        Route::post('/{promotion}/start', 'PromotionController@start')->name('start');
        Route::post('/{promotion}/finish', 'PromotionController@finish')->name('finish');
        Route::post('/{promotion}/attach', 'PromotionController@attach')->name('attach');
        Route::post('/{promotion}/detach', 'PromotionController@detach')->name('detach');
        Route::post('/{promotion}/set', 'PromotionController@set')->name('set');
    });
    Route::Resource('promotion', 'PromotionController');
});

