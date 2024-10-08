<?php

//Аутентификация
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', 'SitemapXmlController@index');

Route::get('/page/{slug}', 'WebController@page')->name('page.view');

Route::get('/employees', 'EmployeeController@index')->name('employee.index');
Route::get('/employee/{slug}', 'EmployeeController@view')->name('employee.view');

Route::get('/specialization', 'SpecializationController@index')->name('specialization.index');
Route::get('/specialization/{slug}', 'SpecializationController@view')->name('specialization.view');

Route::get('/test', 'WebController@test')->name('test');
Route::get('/', 'WebController@home')->name('home');


Route::get('/classification', 'ClassificationController@index')->name('classification.index');
Route::get('/classification/{slug}', 'ClassificationController@view')->name('classification.view');

Route::get('/service', 'ServiceController@index')->name('service.index');
Route::get('/service/{slug}', 'ServiceController@view')->name('service.view');

Route::get('/promotion', 'PromotionController@index')->name('promotion.index');
Route::get('/promotion/{slug}', 'PromotionController@view')->name('promotion.view');


Route::post('/feedback/get-form', 'FeedbackController@get_form')->name('feedback.get-form');
Route::post('/feedback/send-form', 'FeedbackController@send_form')->name('feedback.send-form');
