<?php

//Аутентификация
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', 'SitemapXmlController@index');

Route::get('/page/{slug}', 'WebController@page')->name('page.view');

Route::get('/employees', 'EmployeeController@index')->name('employee.index');
Route::get('/employee/{employee}', 'EmployeeController@view')->name('employee.view');

Route::get('/', 'WebController@home')->name('home');
