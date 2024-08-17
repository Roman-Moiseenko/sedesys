<?php

use Illuminate\Support\Facades\Route;


Route::get('/settings', 'SettingController@index')->name('setting.index');
Route::get('/setting/organization', 'SettingController@organization')->name('setting.organization');
Route::get('/setting/office', 'SettingController@office')->name('setting.office');
Route::get('/setting/web', 'SettingController@web')->name('setting.web');
Route::get('/setting/notification', 'SettingController@notification')->name('setting.notification');
Route::get('/setting/mail', 'SettingController@mail')->name('setting.mail');

Route::put('/setting', 'SettingController@update')->name('setting.update');
