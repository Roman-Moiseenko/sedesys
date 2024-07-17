<?php


use Illuminate\Support\Facades\Route;


Route::group([
    'namespace' => 'Auth',
], function() {
    Route::any('/logout', 'LoginController@logout')->name('logout');
});

Route::resource('staff', 'StaffController');
