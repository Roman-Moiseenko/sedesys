<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'feedback',
        'as' => 'feedback.',

    ],
    function () {

        Route::post('/template/{template}/toggle', 'TemplateController@toggle')->name('template.toggle');

        Route::group([
            'prefix' => 'feedback',
            'as' => 'feedback.',

        ],
            function () {

                Route::get('/dashboard', 'FeedbackController@dashboard')->name('dashboard');
                Route::post('/{feedback}/to-email', 'FeedbackController@to_email')->name('to-email');
                Route::post('/{feedback}/to-completed', 'FeedbackController@to_completed')->name('to-completed');
                Route::post('/{feedback}/to-archive', 'FeedbackController@to_archive')->name('to-archive');
                Route::post('/{feedback}/from-archive', 'FeedbackController@from_archive')->name('from-archive');
                Route::post('/{feedback}/set-staff', 'FeedbackController@set_staff')->name('set-staff');


            });

        Route::Resource('feedback', 'FeedbackController')->only(['index', 'show']);
        Route::Resource('template', 'TemplateController');
    }
);

