<?php

use Illuminate\Http\Request;

Route::post('auth', 'API\AuthController@index')->name('auth.index');
Route::post('login', 'API\AuthController@login')->name('auth.login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
