<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductsController;
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

Route::group(['prefix' => 'auth'], function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::get('products', [ProductsController::class, 'products']);

Route::group(['prefix' => 'cart', 'middleware' => 'jwtAuth'], function(){
    Route::get('user', [CartController::class, 'userCart']);
    Route::post('add', [CartController::class, 'addToCart']);
    Route::post('deleteFromCart', [CartController::class, 'deleteFromCart']);
    Route::post('updateCart', [CartController::class, 'updateCart']);
    Route::post('deleteCart', [CartController::class, 'deleteCart']);
    Route::get('getAllCarts', [CartController::class, 'getAllCarts']);
});