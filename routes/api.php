<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'orders', 'name' => 'orders.'], function () {
    Route::post('create', 'OrderController@create')->name('create');

    Route::group(['middleware' => ['check_order_exists']], function () {
        Route::post('confirm/{id}', 'OrderController@confirm')->name('confirm');
        Route::post('deliver/{id}', 'OrderController@deliver')->name('deliver');
        Route::post('cancel/{id}', 'OrderController@cancel')->name('cancel');
    });
});
