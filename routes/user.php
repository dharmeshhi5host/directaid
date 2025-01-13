<?php

use Illuminate\Support\Facades\Route;

Route::get('login', 'LoginController@index')->name('login');
Route::post('login', 'LoginController@loginCheck')->name('loginCheck');
Route::post('ajaxLoginCheck', 'LoginController@ajaxLoginCheck')->name('ajaxLoginCheck');
