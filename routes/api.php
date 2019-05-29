<?php

use Illuminate\Http\Request;


Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');

Route::middleware(['auth:api'])->group(function () {
    Route::get('user', 'PassportController@details');
    Route::get('logout', 'PassportController@logout');
    Route::resource('products', 'ProductController');
});
