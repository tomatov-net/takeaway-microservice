<?php

use Illuminate\Http\Request;

Route::post('auth/login', 'Auth\LoginController@login');
Route::post('auth/register', 'Auth\RegisterController@create');


Route::group(['prefix' => 'orders', 'name' => 'orders.', 'middleware' => 'jwt.auth'], function () {
    Route::post('create', 'OrderController@create')->middleware(['role:customer'])->name('create');

    Route::group(['middleware' => ['check_order_exists', 'role:operator,admin']], function () {
        Route::post('confirm/{id}', 'OrderController@confirm')->name('confirm');
        Route::post('deliver/{id}', 'OrderController@deliver')->name('deliver');
    });
});
