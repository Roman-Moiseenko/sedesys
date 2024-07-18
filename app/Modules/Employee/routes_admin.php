<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'employee',
        'as' => 'employee.'
    ],
    function() {
        Route::resource('employee', 'EmployeeController');
        Route::Resource('operating', 'OperatingController');
        Route::Resource('message', 'MessageController');
    }
);


