<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'employee',
        'as' => 'employee.'
    ],
    function() {
        Route::resource('employee', 'EmployeeController');
        Route::Resource('specialization', 'SpecializationController');

        Route::post('/employee/{employee}/toggle', 'EmployeeController@toggle')->name('employee.toggle');
        //Route::post('/employee/{employee}/attach', 'EmployeeController@attach')->name('employee.attach');

        Route::group([
            'prefix' => 'specialization',
            'as' => 'specialization.'
        ], function() {
            Route::post('/{specialization}/toggle', 'SpecializationController@toggle')->name('toggle');
            Route::post('/{specialization}/attach', 'SpecializationController@attach')->name('attach');
            Route::post('/{specialization}/up', 'SpecializationController@up')->name('up');
            Route::post('/{specialization}/down', 'SpecializationController@down')->name('down');
            Route::post('/{specialization}/detach', 'SpecializationController@detach')->name('detach');
        });
    }
);


