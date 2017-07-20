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

Route::group(['middleware'=>'check.token'], function () {
    Route::get('products', 'ProductController@getProducts');
    Route::post('cart', 'CartController@addProductToCart');
    Route::delete('cart/{product_id}', 'CartController@deleteProductFromCart');
    Route::get('cart', 'CartController@getProductsInCart');
});