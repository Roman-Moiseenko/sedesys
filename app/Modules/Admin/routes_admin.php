<?php


use Illuminate\Support\Facades\Route;


Route::group([
    'namespace' => 'Auth',
], function() {
    Route::any('/logout', 'LoginController@logout')->name('logout');
});

Route::group([
    'prefix' => 'staff',
    'as' => 'staff.',
], function() {
    Route::post('/{staff}/password', 'StaffController@password')->name('password');
    Route::post('/{staff}/toggle', 'StaffController@toggle')->name('toggle');
    Route::post('/{staff}/responsibility', 'StaffController@responsibility')->name('responsibility');
});


Route::resource('staff', 'StaffController');


