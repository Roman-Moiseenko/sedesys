<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'employee',
        'as' => 'employee.'
    ],
    function() {
        Route::resource('employee', 'EmployeeController');
//        Route::Resource('specialization', 'SpecializationController');
        Route::post('/employee/{employee}/toggle', 'EmployeeController@toggle')->name('employee.toggle');

    }
);


