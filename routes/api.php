<?php

Route::get('user', 'API\UserController@show')->name('auth.user.show');
Route::put('user', 'API\UserController@update')->name('auth.user.update');
Route::delete('user', 'API\UserController@destroy')->name('auth.user.destroy');

Route::post('login', 'API\Auth\LoginController@login')->name('login');
Route::post('logout', 'API\Auth\LogoutController@logout')->name('logout');
Route::post('register', 'API\Auth\RegisterController@register')->name('register');
