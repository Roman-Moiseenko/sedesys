<?php

//Аутентификация
use Illuminate\Support\Facades\Route;


Route::get('/', 'WebController@home')->name('home');
