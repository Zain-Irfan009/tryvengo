<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['verify.shopify']], function () {
    Route::get('/', [App\Http\Controllers\OrderController::class, 'allOrders'])->name('home');
    Route::get('sync-order', [App\Http\Controllers\OrderController::class, 'shopifyOrders'])->name('sync.orders');

});
