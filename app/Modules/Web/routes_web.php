<?php

//Аутентификация
use Illuminate\Support\Facades\Route;

Route::get('/page/{slug}', 'WebController@page')->name('page.view');
Route::get('/', 'WebController@home')->name('home');
Route::get('/employee/{employee}', 'EmployeeController@view')->name('employee.view');

