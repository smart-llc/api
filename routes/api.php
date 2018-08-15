<?php

Route::post('auth', 'API\AuthController@index')->name('auth.index');
Route::post('login', 'API\AuthController@login')->name('auth.login');

Route::get('user', 'API\UserController@show');
Route::put('user', 'API\UserController@update');
Route::delete('user', 'API\UserController@destroy');
