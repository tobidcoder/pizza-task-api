<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/login', 'PassportController@login');
Route::post('/register', 'PassportController@register');
Route::post('/add-to-cart', 'CartController@store');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', 'PassportController@details');
    Route::post('/save-shipping-address', 'PassportController@saveAddress');
    Route::post('/order/items', 'OrderController@getOrderItems');
    Route::post('/orders', 'OrderController@index');

});