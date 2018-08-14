<?php

use Illuminate\Http\Request;

Route::post('auth', 'API\AuthController@index')->name('auth.index');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
