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
        Route::group([
            'prefix' => 'employee',
            'as' => 'employee.'
        ], function() {
            Route::post('/{employee}/toggle', 'EmployeeController@toggle')->name('toggle');
            Route::post('/{employee}/attach-service', 'EmployeeController@attach')->name('attach-service');
            Route::post('/{employee}/detach-service', 'EmployeeController@detach')->name('detach-service');
        });

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


